<?php

namespace App\Http\Livewire\ToDo;

use App\Models\ToDo\Board;
use App\Models\ToDo\Task;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TaskIndexController extends Component
{
    public $myBoards, $myDay, $importantTasks, $retardedTasks, $pendingTasks, $completeTasks;

    public $boardId;

    // Modales
    public $crateBoard = false, $modalBoxicon = false;

    // Variables de new board
    public $nameBoard, $iconBoard, $commentBoard;

    protected $listeners = [
        '$refresh', 'receiveIconToBoxicon'
    ];

    public function updatedIconBoard()
    {
        $this->iconBoard = trim($this->iconBoard);
    }

    public function mount()
    {
        $MyBoard = Board::task()->first();
        $this->boardId = $MyBoard->id;
    }

    public function render()
    {
        $this->myBoards = Board::withCount('tasks')
            ->author()
            ->get();

        $this->myDay = Task::author()
            ->today()
            ->count();

        $this->importantTasks = Task::author()
            ->important()
            ->count();

        $this->retardedTasks = Task::author()
            ->retarded()
            ->count();

        $this->pendingTasks = Task::author()
            ->pending()
            ->count();

        $this->completeTasks = Task::author()
            ->complete()
            ->count();

        return view('livewire.toDo.index');
    }


    public function changeSelect($id)
    {
        $this->boardId = $id;
        $this->emit('changeBoard', $this->boardId);
    }

    public function receiveIconToBoxicon($icon)
    {
        $this->iconBoard = $icon;
        $this->modalBoxicon = false;
    }

    public function saveBoard()
    {
        $rules = [
            'nameBoard' => 'required|min:3|max:13',
            'iconBoard' => (strlen($this->iconBoard) > 0 ? "string|regex:/(^<i class=)/i" : ''),
            'commentBoard' => (strlen($this->commentBoard) > 0 ? "string|min:3" : ''),
        ];

        $messages = [
            'nameBoard.required' => 'El nombre de la lista es requerido',
            'nameBoard.min' => 'El nombre de la lista debe de tener más 3 caracteres',
            'nameBoard.max' => 'El nombre de la lista no debe de ser mayor a 13 caracteres',
            'iconBoard.string' => 'El campo de icono es invalido',
            'iconBoard.regex' => 'El valor del campo no es correcto',
            'commentBoard.string' => 'El formato no es correcto',
            'commentBoard.min' => 'El comentario debe de tener de tener más 3 caracteres'
        ];

        $this->validate($rules, $messages);

        Board::create([
            'name' => $this->nameBoard,
            'icono' => $this->iconBoard,
            'comment' => $this->commentBoard,
            'author_id' => Auth::user()->id
        ]);
        $this->resetVarBoard();
        $this->crateBoard  = false;
    }

    public function resetVarBoard()
    {
        $this->nameBoard = "";
        $this->iconBoard = "";
        $this->commentBoard = "";
    }

    public function closeViewCreateBoard()
    {
        $this->resetVarBoard();
        $this->resetValidation();
        $this->crateBoard = false;
    }
}
