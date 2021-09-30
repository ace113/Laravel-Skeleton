<?php

use App\Models\Page;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('pages')->delete();

        $pages = [
            [
                'title' => 'About Us',
                'slug' => 'about-us',
                'body' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia molestias sunt, nesciunt est, dolores impedit enim exercitationem quas illo, recusandae atque velit!"
            ],
            [
                'title' => 'Terms And Conditions',
                'slug' => 'terms',
                'body' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia molestias sunt, nesciunt est, dolores impedit enim exercitationem quas illo, recusandae atque velit!"
            ],
            [
                'title' => 'Privacy Policy',
                'slug' => 'privacy-policy',
                'body' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia molestias sunt, nesciunt est, dolores impedit enim exercitationem quas illo, recusandae atque velit!"
            ],
        ];

        foreach($pages as $page){
            Page::create($page);
        }
    }
}
