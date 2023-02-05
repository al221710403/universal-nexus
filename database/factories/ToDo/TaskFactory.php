<?php

namespace Database\Factories\ToDo;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [
            'title' => $this->faker->sentence(4),
            'content' => $this->faker->word(),
            'color' => $this->faker->hexColor(),
            'date_expiration' => $this->faker->dateTimeBetween($startDate = '-' . rand(1, 5) . ' days', $endDate = '+' . rand(1, 30) . ' days', $timezone = null),
            'store_tank' => (bool)random_int(0, 1),
            'priority' => (bool)random_int(0, 1),
            'status' => $this->faker->randomElement(['Pendiente', 'Trabajando', 'Completado', 'Retrasado']),
        ];
    }
}
