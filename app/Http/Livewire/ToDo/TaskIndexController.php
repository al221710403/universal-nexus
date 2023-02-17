<?php

namespace App\Http\Livewire\ToDo;

use Livewire\Component;
use App\Models\ToDo\Task;
use App\Traits\FileTrait;
use App\Models\ToDo\Board;
use App\Models\PredefinedFile;
use Illuminate\Support\Facades\Auth;

class TaskIndexController extends Component
{
    use FileTrait;
    // Variables del utilizadas en el menu
    public $myBoards, // Todos los tableros
        $myDay, // Tablero de mi dia
        $importantTasks,
        $retardedTasks,
        $pendingTasks,
        $completeTasks;

    // $boardId change for boardSelected
    public $boardSelected;

    // Modales
    public $crateBoard = false, // Modal para crear una nueva lista
        $modalBoxicon = false, // modal del boxicon
        $modalNoteTask = false;

    // Variables utilizadas para la nueva lista
    public $nameBoard,
        $iconBoard,
        $commentBoard;

    // Variables para editar nota de tarea
    public $taskEdit;
    // , $newComment;

    protected $listeners = [
        '$refresh',
        'receiveIconToBoxicon', //Recibe el icono del modal Boxicon
        'changeSelect',
        'editNote',
        'saveNoteTask'
    ];

    // Quita los espacios iniciales y finales del input
    // del icono
    public function updatedIconBoard()
    {
        $this->iconBoard = trim($this->iconBoard);
    }

    public function mount()
    {
        $MyBoard = Board::select('id')->task()->first();
        $this->boardSelected = $MyBoard->id; //Selecciona el tablero de tareas
    }

    public function render()
    {
        // $task = Task::find(27);
        // dd($task->files);
        // Coleccion de tables
        $this->myBoards = Board::select('id', 'name', 'icono')
            ->orderBy('name')
            ->withCount('tasks')
            ->author()
            ->get()
            ->toArray();

        // Contador del tablero de mi dia
        $this->myDay = Task::author()
            ->today()
            ->count();

        // Contador tareas importantes
        $this->importantTasks = Task::author()
            ->important()
            ->count();

        // Contador de tareas retrasadas
        $this->retardedTasks = Task::author()
            ->retarded()
            ->count();

        // Contador de tareas pendientes
        $this->pendingTasks = Task::author()
            ->pending()
            ->count();

        // Contador de tareas completadas
        $this->completeTasks = Task::author()
            ->complete()
            ->count();

        return view('livewire.toDo.index');
    }

    /**
     * title: Cambio de tablero
     * Descripción: Cambia el tablero seleccionado del menu
     * @access public
     * @param  $id string
     * @return El nuevo valor del tablero
     * @author Cristian Milton Fidel Pascual <al221710403@gmail.com>
     * @date 2023-02-07 17:54:22
     */
    public function changeSelect($id)
    {
        $this->boardSelected = $id;
        $this->emit('changeBoard', $this->boardSelected);
    }

    /**
     * title: Guarda lista
     * Descripción: Guarda la nueva lista
     * @access public
     * @param  Parametros necesarios para la nueva lista
     * @author Cristian Milton Fidel Pascual <al221710403@gmail.com>
     * @date 2023-02-07 17:56:16
     */
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

        $newBoard = Board::create([
            'name' => $this->nameBoard,
            'icono' => $this->iconBoard,
            'comment' => $this->commentBoard,
            'author_id' => Auth::user()->id
        ]);

        $background = PredefinedFile::where('module', 'todo-list')
            ->where('use', 'background')
            ->orderBy('name')
            ->get();

        if ($background->count() > 0) {
            $newBoard->background_image = $background->random()->url_file;
            $newBoard->save();
        }

        $this->resetVarBoard();
        $this->crateBoard  = false;
    }

    /**
     * title: Recibe Icons
     * Descripción: Recibe el icono del componente livewire boxicon
     * @access public
     * @param  $icon string
     * @author Cristian Milton Fidel Pascual <al221710403@gmail.com>
     * @date 2023-02-07 18:04:58
     */
    public function receiveIconToBoxicon($icon)
    {
        $this->iconBoard = $icon;
        $this->modalBoxicon = false;
    }

    /**
     * title: Reset variebles Board
     * Descripción: Resetea las variables y validaciones del board
     * @access public
     * @author Cristian Milton Fidel Pascual <al221710403@gmail.com>
     * @date 2023-02-07 18:06:16
     */
    public function resetVarBoard()
    {
        $this->nameBoard = "";
        $this->iconBoard = "";
        $this->commentBoard = "";
        $this->resetValidation();
    }

    /**
     * title: Open modal Board
     * Descripción: Abre el moadl para crear una nueva lista
     * @access public
     * @author Cristian Milton Fidel Pascual <al221710403@gmail.com>
     * @date 2023-02-07 18:07:32
     */
    public function openViewCreateBoard()
    {
        $this->crateBoard = true;
    }

    /**
     * title: Close modal Board
     * Descripción: Cierra y resetea los parametros del modal Board
     * @access public
     * @author Cristian Milton Fidel Pascual <al221710403@gmail.com>
     * @date 2023-02-07 18:07:32
     */
    public function closeViewCreateBoard()
    {
        $this->resetVarBoard();
        $this->crateBoard = false;
    }



    public function editNote(Task $task)
    {
        // dd($task);
        $this->emit('set-data-editor', $task->content);
        $this->taskEdit = $task;
        // $this->newComment = $task->content;
        $this->modalNoteTask = true;
    }

    public function saveNoteTask($body)
    {
        // dd($body);
        $this->taskEdit->content = $body;
        $this->taskEdit->save();
        $this->closeModalEditNote();
        $this->emitTo('to-do.board-show', '$refresh');
        $this->emitTo('to-do.task-show', '$refresh');
    }

    public function closeModalEditNote()
    {
        $this->reset(['taskEdit']);
        $this->modalNoteTask = false;
    }
}
