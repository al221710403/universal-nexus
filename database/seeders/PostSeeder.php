<?php

namespace Database\Seeders;

use Faker\Factory;
use App\Models\Publish\Post;
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
        $posts = Post::factory(50)->create();

        foreach ($posts as $post) {
            $countTags = rand(1, 3);
            for ($i = 1; $i <= $countTags; $i++) {
                $faker = Factory::create();
                $post->attachTag($faker->sentence(2));
            }
        }
    }
}
