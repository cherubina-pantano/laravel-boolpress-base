<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Tag;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->get();

        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Get all tags
        $tags = Tag::all();
        return view('posts.create', compact('tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        //dd($data);

        //Validate
        $request->validate($this->ruleValidation());

        //Post SLUG
        $data['slug'] = Str::slug($data['title'], '-');

        //Se img presente
        if(!empty($data['path_img'])) {
            $data['path_img'] = Storage::disk('public')->put('images', $data['path_img']);
        }

        //Save to DB
        $newPost = new Post();
        $newPost->fill($data);

        $saved = $newPost->save();

        if($saved) {
            if (!empty($data['tags'])) {
                // Pivot tra posts e tags
                $newPost->tags()->attach($data['tags']);
            }
            return redirect()->route('posts.index');
        } else {
            return redirect()->route('home');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $post = Post::where('slug', $slug)->first();

        //Check: esiste? not found 404
        if(empty($post)) {
            abort(404);
        }

        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $post = Post::where('slug', $slug)->first();
        $tags = Tag::all();

        //Check: esiste? not found 404
        if(empty($post)) {
            abort(404);
        }

        return view('posts.edit', compact('post', 'tags'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Get data from FORM
        $data = $request->all();

        //VALIDAZIONE
        $request->validate($this->ruleValidation());

        //Get post to update
        $post = Post::find($id);

        //Slug update
        $data['slug'] = Str::slug($data['title'], '-');

        //Se cambia l'img
        if(!empty($data['path_img'])) {
            //Elimina l'img precedente/presente
            if(!empty($post->path_img)) {
                Storage::disk('public')->delete($post->path_img);
            }
            //Aggiunge l'img nuova
            $data['path_img'] = Storage::disk('public')->put('images', $data['path_img']);
        }

        //UPDATE DB
        $updated = $post->update($data);  // <--$fillable nel Model

        if($updated) {
            if (!empty($data['tags'])) {
                $post->tags()->sync($data['tags']);

            } else {
                $post->tags()->detach();
            }
            return redirect()->route('posts.show', $post->slug);
        } else {
            return redirect()->route('home');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post) // <-- versione compatta di $post = Post::find($id)
    {
        //$post = Post::find($id); 
        $title = $post->title;
        $image = $post->path_img;
        
        $post->tags()->detach();
        $deleted = $post->delete();

        if($deleted) {
            //Elimina l'img se è presente
            if(!empty($image)) {
                Storage::disk('public')->delete($image);
            }
            return redirect()->route('posts.index')->with('post-deleted', $title);
        } else {
            return redirect()->route('home');
        }
    }

    /**
     *  Funzione di validazione
     **/
    private function ruleValidation() {
        return [
            'title' => 'required',
            'body' => 'required',
            'path_img' => 'mimes:jpg,bmp,png'
        ];
    }
}
