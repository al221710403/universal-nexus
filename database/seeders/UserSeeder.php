<?php

namespace Database\Seeders;

use App\Models\ToDo\Board;
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



        Task::factory(30)->create([
            'author_id' => $user->id,
            'board_id' => $myBoard[0]->id
        ]);


        $users = User::factory(15)->create();

        foreach ($users as $user) {
            $board = Board::factory(1)->create([
                'author_id' => $user->id
            ]);

            Task::factory(30)->create([
                'author_id' => $user->id,
                'board_id' => $board[0]->id
            ]);
        }
    }
}
