<?php

namespace App\Http\Livewire\ToDo;

use Livewire\Component;
use App\Models\ToDo\Task;
use App\Models\ToDo\Board;
use Illuminate\Database\Eloquent\Builder;

class BoardShow extends Component
{
    public $boardId;

    public $title, $board, $tasks;

    public $showTaskId;

    protected $listeners = [
        '$refresh',
        'changeBoard',
        'closeTask'
    ];

    public function render()
    {
        $this->updateBoard($this->boardId);
        return view('livewire.toDo.board-show');
    }

    public function changeBoard($id)
    {
        $this->boardId = $id;
        $this->updateBoard($this->boardId);
    }


    public function updateBoard($id)
    {
        $this->title = $id;
        if (is_numeric($id)) {
            $this->board = Board::author()->board($id)->first();
            $this->tasks = $this->board->tasks;
        } else {
            switch ($id) {
                case 'today':
                    $this->title = "My día";
                    $this->tasks = Task::author()
                        ->$id()
                        ->get();
                    break;
                case 'important':
                    $this->title = "Importante";
                    $this->tasks = Task::author()
                        ->$id()
                        ->get();
                    break;
                case 'retarded':
                    $this->title = "Retrasado";
                    $this->tasks = Task::author()
                        ->$id()
                        ->get();
                    break;
                case 'pending':
                    $this->title = "Pendiente";
                    $this->tasks = Task::author()
                        ->$id()
                        ->get();
                    break;
                case 'complete':
                    $this->title = "Completado";
                    $this->tasks = Task::author()
                        ->$id()
                        ->get();
                    break;

                default:
                    $this->title = "Otros";
                    $this->tasks = "";
                    break;
            }
            // dd($this->tasks);
        }
    }

    public function setImportant(Task $task)
    {
        $task->priority = $task->priority == 1 ? 0 : 1;
        $task->save();
        if ($this->showTaskId) {
            if ($task->id == $this->showTaskId) {
                $this->emitTo('to-do.task-show', '$refresh');
            }
        }
        $this->emitTo('to-do.task-index-controller', '$refresh');
    }

    public function setComplete(Task $task)
    {
        $task->status = $task->status == "Completado" ? "Pendiente" : "Completado";
        $task->save();
        if ($this->showTaskId) {
            if ($task->id == $this->showTaskId) {
                $this->emitTo('to-do.task-show', '$refresh');
            }
        }
        $this->emitTo('to-do.task-index-controller', '$refresh');
    }

    public function selectedTaskView($id)
    {
        // dd($this->tasks);
        // $example = Task::find($id);

        // $example = Task::where('id', $id)
        //     ->withCount([
        //         'steps as steps',
        //         'steps as steps_complete' => function (Builder $query) {
        //             $query->where('complete', true);
        //         }
        //     ])
        //     ->first();
        // dd($example, $example->is_today);
        // dd($example, $example->parent);
        $this->emitTo('to-do.task-show', 'getTaskId', $id);
        $this->showTaskId = $id;
    }

    public function closeTask()
    {
        $this->reset('showTaskId');
    }
}
