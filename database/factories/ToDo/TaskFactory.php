<?php

namespace Database\Factories\ToDo;

use App\Models\ToDo\Task;
use Carbon\Carbon;
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
        // dd(Task::where('author_id', 1)->get());
        $created_at = $this->faker->dateTimeBetween($startDate = '-' . rand(0, 10) . ' days');
        $date_expiration = Carbon::parse($created_at)->addDay(rand(0, 10));
        $date_remind_me =  Carbon::parse($date_expiration)->subDay(rand(0, 1));
        $my_day = (bool)random_int(0, 1);

        $have_parent = false;
        if ((bool)random_int(0, 1)) {
            if (Task::where('author_id', 1)->count() > 0) {
                $have_parent = true;
                $parent_id = Task::where('author_id', 1)->get()->random()->id;
            }
        }
        $color = (bool)random_int(0, 1);
        return [
            'title' => $this->faker->sentence(4),
            'content' => $this->faker->word(),
            'background_color' => ($color ? $this->faker->hexColor() : '#FFFFFF'),
            'text_color' => ($color ? $this->faker->hexColor() : '#6b7280'),
            'date_expiration' => $date_expiration,
            'date_remind_me' => $date_remind_me,
            'date_remind_me' => ($my_day ? now() : null),
            'repeat_task' => $this->faker->randomElement(['Diariamente', 'Semanalmente', 'Mensualmente', 'Anualmente', null]),
            // 'store_tank' => (bool)random_int(0, 1),
            'priority' => (bool)random_int(0, 1),
            'status' => $this->faker->randomElement(['Pendiente', 'Trabajando', 'Completado', 'Retrasado']),
            'taskable_id' => ($have_parent ? $parent_id : null),
            'taskable_type' => ($have_parent ? 'App\Models\ToDo\Task' : null),
            'created_at' => $created_at,
            'updated_at' => $created_at,
        ];
    }
}
