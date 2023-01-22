<?php

namespace Database\Seeders;

use App\Models\Publish\Tag;
use App\Models\Publish\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;'); // Desactivamos la revisión de claves foráneas
        DB::table('posts_tags')->truncate(); // Eliminar datos de tabla
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;'); // Reactivamos la revisión de claves foráneas

        Tag::factory(10)->create();

        $posts = Post::factory(50)->create();

        foreach ($posts as $post) {
            $countTags = rand(1, 3);
            for ($i = 1; $i <= $countTags; $i++) {
                DB::table('posts_tags')->insert([
                    'post_id' => $post->id,
                    'tag_id' => Tag::all()->random()->id
                ]);
            }
        }
    }
}
