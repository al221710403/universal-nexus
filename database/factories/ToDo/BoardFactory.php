<?php

namespace Database\Factories\ToDo;

use Illuminate\Database\Eloquent\Factories\Factory;

class BoardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => 'Tareas',
            'comment' => $this->faker->word(),
            'background_image' => $this->faker->imageUrl(250, 250),
        ];
    }
}
