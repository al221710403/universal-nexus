<?php

namespace Database\Factories\Publish;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->sentence();
        $slug = Str::slug($title);
        return [
            'title' => $title,
            'body' => $this->faker->word(),
            'published' => $this->faker->randomElement([1, 0]),
            'publish_date' => $this->faker->dateTimeBetween($startDate = '-' . rand(1, 5) . ' years', $endDate = 'now', $timezone = null),
            // 'featured_image' => 'publish/featured_image/' . $this->faker->image('public/storage/publish/featured_image', 640, 480, null, false),
            'featured_image' => $this->faker->imageUrl(250, 250),
            'featured_image_caption' => $this->faker->sentence(),
            'author_id' => User::all()->random()->id,
            'slug' => $slug
        ];
    }
}
