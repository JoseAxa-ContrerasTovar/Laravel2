<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Post::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        for ($i=0; $i < 30; $i++) { 
            $c = Category::inRandomOrder()->first();

            $title = Str::random(20);

            Post::create(
                [
                    'title' => $title,
                    'slug' => Str::slug($title),
                    'content' => "<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Saepe odit at inventore eaque dolorum repudiandae vero tenetur facilis animi. Assumenda debitis adipisci quasi inventore nemo, tempore facere ad sunt itaque.</p>",
                    'category_id' => $c->id,
                    'description' => "Lorem ipsum dolor sit amet consectetur adipisicing elit.",
                    'posted' => "yes",
                ]
            );
        }
    }
}
