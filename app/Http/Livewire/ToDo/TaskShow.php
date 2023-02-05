<?php

namespace App\Http\Livewire\ToDo;

use App\Models\ToDo\StepTask;
use Livewire\Component;
use App\Models\ToDo\Task;
use Illuminate\Database\Eloquent\Builder;

class TaskShow extends Component
{
    public $getId;

    public $readyToLoad = false;

    protected $listeners = [
        '$refresh',
        'getTaskId'
    ];


    public function loadPosts()
    {
        $this->readyToLoad = true;
    }

    public function render()
    {
        // $example = Task::where('id', $id)
        //     ->withCount([
        //         'steps as steps',
        //         'steps as steps_complete' => function (Builder $query) {
        //             $query->where('complete', true);
        //         }
        //     ])
        //     ->first();
        // dd($example);

        return view('livewire.toDo.task-show', [
            'task' => $this->readyToLoad
                ? Task::where('id', $this->getId)->withCount([
                    'steps',
                    'steps as steps_complete' => function (Builder $query) {
                        $query->where('complete', true);
                    }
                ])->first()
                : [],
        ]);

        // return view('livewire.toDo.task-show', [
        //     'task' => $this->readyToLoad
        //         ? Task::find($this->getId)
        //         : [],
        // ]);
    }

    public function getTaskId($task)
    {
        $this->getId = $task;
    }

    public function setImportant(Task $task)
    {
        $task->priority = $task->priority == 1 ? 0 : 1;
        $task->save();
        // $this->emit('noty-primary', 'Cambios guardados');
        $this->emitTo('to-do.task-index-controller', '$refresh');
        $this->emitTo('to-do.board-show', '$refresh');
    }

    public function completeStep(StepTask $step)
    {
        $step->complete = $step->complete == 1 ? 0 : 1;
        $step->save();
        // $this->emit('noty-primary', 'Cambios guardados');
        // $this->emitTo('to-do.task-index-controller', '$refresh');
        $this->emitTo('to-do.board-show', '$refresh');
    }

    public function setComplete(Task $task)
    {
        $task->status = $task->status == "Completado" ? "Pendiente" : "Completado";
        $task->save();
        $this->emitTo('to-do.task-index-controller', '$refresh');
        $this->emitTo('to-do.board-show', '$refresh');
    }

    public function closeViewTask()
    {
        $this->reset(['getId', 'readyToLoad']);
        $this->emitTo('to-do.board-show', 'closeTask');
    }
}
