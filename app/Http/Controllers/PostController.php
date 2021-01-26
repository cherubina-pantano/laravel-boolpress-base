<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

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
        return view('posts.create');
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
            return redirect()->route('posts.index');
        } else {
            return redirect()->route('homepage');
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

        return view('posts.edit', compact('post'));

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
            return redirect()->route('posts.show', $post->slug);
        } else {
            return redirect()->route('homepage');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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
