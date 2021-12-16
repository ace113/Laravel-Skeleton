<?php

use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Post::class, 20)->create()
            ->each(
                function($post){
                   $post->comments()->saveMany(
                        factory(App\Models\Comment::class, rand(2, 5))->make()
                   );
                }
            );
    }
}
