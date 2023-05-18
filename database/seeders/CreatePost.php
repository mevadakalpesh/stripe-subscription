<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;

class CreatePost extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['title' => 'post 1' ,'description' => 'this post 1 description' , 'post_type' => 'Free'],
            ['title' => 'post 2' ,'description' => 'this is Premium post' , 'post_type' => 'Premium'],
            ['title' => 'post 3' ,'description' => 'this post 3 description' , 'post_type' => 'Free'],
        ];

        Post::insert($data );
    }
}
