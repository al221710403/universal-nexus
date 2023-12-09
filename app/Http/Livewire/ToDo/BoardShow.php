<?php

namespace App\Http\Livewire\ToDo;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\ToDo\Task;
use App\Traits\FileTrait;
use App\Models\ToDo\Board;
use Livewire\WithFileUploads;
use App\Models\PredefinedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;

class BoardShow extends Component
{
    use WithFileUploads;
    use FileTrait;

    // Board seleccionado par mostrarse
    public $boardSelected;

    //Variable de carga
    public $readyToLoad = false;

    // Variables del board
    public $searchTask, // buscardor de tareas
        $title, //nombre del tablero
        $board, //Instancia del tablero seleccionado
        $descriptionBoard; //comentario del tablero seleccionado

    //Tarea para mostrar
    public $showTaskId;

    // Tareas dependiendo el status
    public $pendingTasks,
        $workingTasks,
        $completeTasks,
        $delayedTasks;

    // Modales
    public $showCommentBoard = false, // modal del comentario de la lista
        $setColorTask = false,
        $changeBackgroundBoard = false; // modal de cambio de fondo de la lista

    // Varibles de cambio de fondo
    public $uploadBackground = false,
        $link = false, //Interno = false , Externo = true
        $backgroundImage;

    // Varables para cambiar color de la tarea
    public $task, // tarea editada
        $backgroundColor,
        $textColor;

    // Variable para nueva tarea
    public $newTask;


    public function updatingLink()
    {
        $this->reset('backgroundImage');
    }

    public function updatingUploadBackground()
    {
        if (!$this->uploadBackground) {
            $this->reset(['backgroundImage', 'link']);
            $this->resetValidation();
        }
    }

    public function updatedBackgroundImage()
    {
        $img_ext = ['jpg', 'png', 'jpge', 'JPG', 'PNG', 'JPGE'];
        $all_ext = implode(',', $img_ext);

        $this->validate([
            'backgroundImage' => $this->link ? 'url' : 'image|mimes:' . $all_ext,
        ]);
    }

    protected $listeners = [
        '$refresh', //Refresca el componente
        'changeBoard', //Recibe de la vista principal el board seleccionado
        'closeTask',
        'setDeleteTask',
        'setDeleteBoard',
        'deleteFileTask'
    ];

    public function loadPosts()
    {
        $this->readyToLoad = true;
    }

    public function render()
    {
        $this->updateBoard($this->boardSelected);
        $backgrounds = PredefinedFile::where('module', 'todo-list')
            ->where('use', 'background')
            ->orderBy('name')
            ->get();
        return view('livewire.toDo.board-show', compact('backgrounds'));
    }

    /**
     * title: Obtiene el id del tablero
     * Descripción: Obtiene el id del tablero y llama a la funcion de actualizar
     * tablero
     * @access public
     * @param  $id string or int
     * @author Cristian Milton Fidel Pascual <al221710403@gmail.com>
     * @date 2023-02-07 21:06:02
     */
    public function changeBoard($id)
    {
        $this->boardSelected = $id;
        $this->updateBoard($this->boardSelected);
    }

    /**
     * title: Actualizar el tablero
     * Descripción: Actualizar el tablero y las tareas del tablero
     * @access public
     * @param  $id string or int
     * @return El modelo del tablero y las tareas
     * @author Cristian Milton Fidel Pascual <al221710403@gmail.com>
     * @date 2023-02-07 21:08:32
     */
    public function updateBoard($id)
    {
        $this->title = $id;
        if (is_numeric($id)) {
            $this->board = $this->readyToLoad ?
                Board::select('id', 'name', 'background_image', 'background_default', 'background_location', 'comment')->author()->board($id)->first() :
                [];
            $this->descriptionBoard = $this->readyToLoad ? $this->board->comment : '';

            $this->pendingTasks = $this->readyToLoad ?
                $this->board->tasks()
                ->search($this->searchTask)
                ->where('status', 'Pendiente')
                ->orderBy('created_at', 'desc')
                ->get()
                : [];

            $this->workingTasks = $this->readyToLoad ?
                $this->board->tasks()
                ->search($this->searchTask)
                ->where('status', 'Trabajando')
                ->orderBy('created_at', 'desc')
                ->get()
                : [];

            $this->completeTasks = $this->readyToLoad ?
                $this->board->tasks()
                ->search($this->searchTask)
                ->where('status', 'Completado')
                ->orderBy('created_at', 'desc')
                ->get()
                : [];

            $this->delayedTasks = $this->readyToLoad ?
                $this->board->tasks()
                ->search($this->searchTask)
                ->where('status', 'Retrasado')
                ->orderBy('created_at', 'desc')
                ->get()
                : [];
        } else {
            switch ($id) {
                case 'today':
                    $this->title = "Mi día";
                    break;
                case 'important':
                    $this->title = "Importante";
                    break;
                case 'retarded':
                    $this->title = "Retrasado";
                    break;
                case 'pending':
                    $this->title = "Pendiente";
                    break;
                case 'complete':
                    $this->title = "Completado";
                    break;
                default:
                    $this->title = "Otros";
                    break;
            }

            $this->pendingTasks = $this->readyToLoad ?
                Task::author()
                ->$id()
                ->where('status', 'Pendiente')
                ->search($this->searchTask)
                ->orderBy('created_at', 'desc')
                ->get()
                : [];

            $this->workingTasks = $this->readyToLoad ?
                Task::author()
                ->$id()
                ->where('status', 'Trabajando')
                ->search($this->searchTask)
                ->orderBy('created_at', 'desc')
                ->get()
                : [];

            $this->completeTasks = $this->readyToLoad ?
                Task::author()
                ->$id()
                ->search($this->searchTask)
                ->where('status', 'Completado')
                ->orderBy('created_at', 'desc')
                ->get()
                : [];

            $this->delayedTasks = $this->readyToLoad ?
                Task::author()
                ->$id()
                ->search($this->searchTask)
                ->where('status', 'Retrasado')
                ->orderBy('created_at', 'desc')
                ->get()
                : [];
            $this->board = Board::task()->first();
        }
    }

    //============================================================================
    // Funciones pertenecientes al tablero
    //============================================================================

    /**
     * title: Guarda el comentario
     * Descripción: guarda el comentario del tablero seleccionado
     * @access public
     * @author Cristian Milton Fidel Pascual <al221710403@gmail.com>
     * @date 2023-02-07 21:30:25
     */
    public function saveComment()
    {
        $this->board->comment = $this->descriptionBoard;
        $this->board->save();
    }


    public function saveBackgroundBoard()
    {
        if ($this->uploadBackground) {
            $this->board->background_default = false;
            $this->board->background_location = $this->link ? 'externo' : 'local';
            if (!$this->link) {
                $path = 'todo/board';
                if ($this->board->background_image) {
                    if (!$this->board->background_default && $this->board->background_location == 'local') {
                        if (file_exists('storage/' .  $this->board->background_image)) {
                            unlink('storage/' . $this->board->background_image); //si el archivo ya existe se borra
                        }
                    }
                }
                $url = Storage::put($path, $this->backgroundImage);
                $this->backgroundImage = $url;
            }
        } else {
            $this->board->background_default = true;
            $this->board->background_location = "local";
        }
        $this->board->background_image = $this->backgroundImage;
        $this->board->save();
        $this->closeViewBackgroundBoard();
    }

    public function closeViewBackgroundBoard()
    {
        $this->changeBackgroundBoard = false;
        $this->reset(['backgroundImage', 'link', 'uploadBackground']);
        $this->resetValidation();
    }


    public function setDeleteBoard($id)
    {
        $result = Board::deleteBoard($id);
        if ($result) {
            $MyBoard = Board::select('id')->task()->first();
            $this->reset('showTaskId');
            $this->changeBoard($MyBoard->id);
            $this->emitTo('to-do.task-index-controller', 'changeSelect', $MyBoard->id);
            $this->emitTo('to-do.task-index-controller', '$refresh');
            $this->emit('noty-primary', 'Lista borrada exitosamente!');
        } else {
            $this->emit('noty-danger', 'Ups! Hubo un error al eliminar la lista');
        }
    }

    //============================================================================
    // Fin de las funciones pertenecientes al tablero
    //============================================================================


    //============================================================================
    // Funciones pertenecientes las tareas
    //============================================================================

    /**
     * title: Guarda tarea nueva
     * Descripción: Guarda una nueva tarea
     * @access public
     * @author Cristian Milton Fidel Pascual <al221710403@gmail.com>
     * @date 2023-02-07 21:24:31
     */
    public function saveTask()
    {
        if (strlen($this->newTask) > 0) {
            $task = Task::create([
                "title" => $this->newTask,
                "author_id" => Auth::user()->id,
                "board_id" => $this->board->id
            ]);
            $this->newTask = "";
            $this->emitTo('to-do.task-index-controller', '$refresh');
            $this->emitTo('to-do.task-show', 'getTaskId', $task->id, 'edit');
            $this->showTaskId = $task->id;
            $this->emit('noty-primary', 'Tarea creada');
        } else {
            $this->emit('noty-warning', 'Debe de escribir una tarea');
        }
    }

    /**
     * title: Tarea completa
     * Descripción: Completa la tarea
     * @access public
     * @param  $task integer
     * @author Cristian Milton Fidel Pascual <al221710403@gmail.com>
     * @date 2023-02-07 21:46:34
     */
    public function setComplete(Task $task)
    {
        $statusNew = "";
        if ($task->status == "Completado") {
            if (Carbon::parse($task->date_expiration)->format('Y-m-d') < now()->format('Y-m-d')) {
                $statusNew = "Retrasado";
            } else {
                $statusNew = "Pendiente";
            }
        } else {
            $statusNew = "Completado";
        }

        $task->status = $statusNew;
        $task->save();
        if ($this->showTaskId) {
            if ($task->id == $this->showTaskId) {
                $this->emitTo('to-do.task-show', '$refresh');
            }
        }
        $this->emitTo('to-do.task-index-controller', '$refresh');
    }

    /**
     * title: Comienza tarea
     * Descripción: Cambia el estado de la tarea a trabajando
     * @access public
     * @param  $task integer
     * @author Cristian Milton Fidel Pascual <al221710403@gmail.com>
     * @date 2023-02-07 21:46:34
     */
    public function runningTask(Task $task)
    {
        $statusNew = "";
        if ($task->status != 'Trabajando') {
            $statusNew = "Trabajando";
        } else {
            if (Carbon::parse($task->date_expiration)->format('Y-m-d') < now()->format('Y-m-d')) {
                $statusNew = "Retrasado";
            } else {
                $statusNew = "Pendiente";
            }
        }

        $task->status = $statusNew;

        $task->save();
        $this->emitTo('to-do.task-show', '$refresh');
    }

    /**
     * title: Cambia la importancia de la tarea
     * Descripción: Cambia la importancia de la tarea seleccionada
     * @access public
     * @param  $task integer
     * @author Cristian Milton Fidel Pascual <al221710403@gmail.com>
     * @date 2023-02-07 21:46:34
     */
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

    /**
     * title: Modal para cambiar color de la tarea
     * Descripción: Abre el modal de cambio de color
     * @access public
     * @param  $task int
     * @author Cristian Milton Fidel Pascual <al221710403@gmail.com>
     * @date 2023-02-07 21:25:29
     */
    public function viewSetColorTask(Task $task)
    {
        $this->task = $task;
        $this->backgroundColor = $task->background_color;
        $this->textColor = $task->text_color;
        $this->setColorTask = true;
    }

    /**
     * title: Colores default
     * Descripción: Resetea los valores de los colores a su estado por defecto
     * @access public
     * @author Cristian Milton Fidel Pascual <al221710403@gmail.com>
     * @date 2023-02-07 22:00:57
     */
    public function defaultColor()
    {
        $this->backgroundColor = '#FFFFFF';
        $this->textColor = '#6b7280';
    }

    /**
     * title: Cierra modal de color
     * Descripción: Cierra el modal para cambiar los colores de la tarea
     * @access public
     * @author Cristian Milton Fidel Pascual <al221710403@gmail.com>
     * @date 2023-02-07 22:02:43
     */
    public function closeSetColor()
    {
        $this->backgroundColor = "";
        $this->textColor = "";
        $this->task = "";
        $this->setColorTask = false;
    }

    /**
     * title: Guarda los colores
     * Descripción: Guarda los colores de la tarea
     * @access public
     * @author Cristian Milton Fidel Pascual <al221710403@gmail.com>
     * @date 2023-02-07 22:03:50
     */
    public function saveColor()
    {
        $this->task->background_color = $this->backgroundColor;
        $this->task->text_color = $this->textColor;
        $this->task->save();
        $this->closeSetColor();
    }

    /**
     * title: Recibe la tarea a eliminar
     * Descripción: Recibe la tarea que se desea eliminar
     * @access public
     * @param  $task integer
     * @author Cristian Milton Fidel Pascual <al221710403@gmail.com>
     * @date 2023-02-07 22:08:54
     */
    public function setDeleteTask(Task $task)
    {
        if ($task->children->count() > 0) {
            foreach ($task->children as $subtask) {
                $this->deleteTask($subtask->id);
            }
        }
        $this->deleteTask($task->id);
        $this->emit('noty-primary', 'Tarea eliminada correctamente');
        $this->emitTo('to-do.task-index-controller', '$refresh');
    }

    /**
     * title: Elimina la atrea
     * Descripción: Elimina la tarea y registros y archivos relacionados
     * @access public
     * @param  $task int
     * @author Cristian Milton Fidel Pascual <al221710403@gmail.com>
     * @date 2023-02-07 22:09:58
     */
    public function deleteTask($task)
    {
        $task = Task::find($task);
        DB::beginTransaction();
        try {
            // Eliminar colaboradores
            if ($task->collaborators) {
                foreach ($task->collaborators as $collaborator) {
                    $collaborator->delete();
                }
            }

            // Eliminar pasos
            if ($task->steps) {
                foreach ($task->steps as $step) {
                    $step->delete();
                }
            }

            //Eliminar tarea
            $task->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $this->emit('noty-danger', 'Ups!! Hubo un error al eliminar la tarea');
            return $e->getMessage();
        }
    }


    /**
     * title: Selecciona la tarea
     * Descripción: Selecciona la tarea para ver o editar
     * @access public
     * @param  $id int y $action('edit','show') string
     * @return evento
     * @author Cristian Milton Fidel Pascual <al221710403@gmail.com>
     * @date 2023-02-07 22:14:05
     */
    public function selectedTaskView($id, $action = 'show')
    {
        $this->emitTo('to-do.task-show', 'getTaskId', $id, $action);
        $this->showTaskId = $id;
    }


    /**
     * title: resetea la avriable showTaskId
     * Descripción: Resetea la variable para ocultar la ventana
     * @access public
     * @author Cristian Milton Fidel Pascual <al221710403@gmail.com>
     * @date 2023-02-07 22:16:51
     */
    public function closeTask()
    {
        $this->reset('showTaskId');
    }


    public function deleteFileTask($id)
    {
        $this->deleteFile($id);
        if ($this->showTaskId) {
            $this->emitTo('to-do.task-show', '$refresh');
        }
    }

    //============================================================================
    // Fin de las funciones pertenecientes las tareas
    //============================================================================
}
