<?php

namespace Database\Factories\ToDo;

use Illuminate\Database\Eloquent\Factories\Factory;

class StepTaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->sentence(5),
            'complete' => (bool)random_int(0, 1),
        ];
    }
}
