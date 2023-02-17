<?php

namespace Database\Seeders;

use App\Models\ToDo\Board;
use App\Models\ToDo\StepTask;
use App\Models\ToDo\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Cristian Milton Fidel Pascual',
            'username' => 'milton',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345678'),
            'slug' => 'cristian-milton-fidel-pascual'
        ]);

        $myBoard = Board::factory(1)->create([
            'author_id' => $user->id
        ]);


        $myTasks = Task::factory(30)->create([
            'author_id' => $user->id,
            'board_id' => $myBoard[0]->id
        ]);

        foreach ($myTasks as $task) {
            $addStep = rand(1, 5);
            $isAddStep = (bool)random_int(0, 1);

            $isSubtask = (bool)random_int(0, 1);
            if ($isSubtask) {
                $parentTask = Task::where('author_id', $user->id)->get()->random()->id;
                $task->taskable_id = $parentTask;
                $task->taskable_type = 'App\Models\ToDo\Task';
                $task->save();
            }

            if ($isAddStep) {
                StepTask::factory($addStep)->create([
                    'task_id' => $task->id
                ]);
            }
        }


        $users = User::factory(15)->create();

        foreach ($users as $user) {
            $board = Board::factory(1)->create([
                'author_id' => $user->id
            ]);

            Task::factory(10)->create([
                'author_id' => $user->id,
                'board_id' => $board[0]->id
            ]);
        }
    }
}
