<?php

use Illuminate\Database\Seeder;
use App\Post;
use Illuminate\Support\Str;
use Faker\Generator as Faker;


class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        /**
         * FAKERS
        */
        Post::truncate();

        for ($i = 0; $i < 10; $i++) {
            $title = $faker->text(50);

            $newPost = new Post;
            $newPost->title = $title;
            $newPost->body = $faker->paragraphs(1, true);
            $newPost->slug = Str::slug($title, '-');
            $newPost->save();
        }
    }
}
