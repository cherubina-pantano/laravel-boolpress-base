<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Post;
use App\Comment;


class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        //3 comments for every post

        $posts = Post::all();

        foreach ($posts as $post) {

            for($i = 0; $i < 3; $i++) {
                //creare istanza
                $newComment = new Comment();

                //Set valori colonne
                $newComment->post_id = $post->id;   //FK -->id posts
                $newComment->author = $faker->userName();
                $newComment->text = $faker->sentence(10);

                //salvataggio
                $newComment->save();
            }            
        }

    }
}
