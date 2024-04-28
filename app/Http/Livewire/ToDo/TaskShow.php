<?php

namespace App\Http\Livewire\ToDo;

use App\Models\Notification;
use Carbon\Carbon;
use Livewire\Component;
use App\Models\ToDo\Task;
use App\Traits\FileTrait;
use App\Models\ToDo\StepTask;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use App\Notifications\DesktopNotification;

use function GuzzleHttp\Promise\task;

class TaskShow extends Component
{
    use WithFileUploads;
    use FileTrait;

    public $getId, $action, $newStep;


    public $readyToLoad = false;

    // Add fecha de vencimiento
    public $typeDateSelected, $dateExpiration;

    // Add fecha de vencimiento
    public $typeDateRemindMeSelected, $dateRemindMe;

    // Variables de archivos
    public $modal_files = false,
        $old_files, //Archivos anteriores
        $files = []; //Archivos nuevos

    protected $listeners = [
        '$refresh',
        'getTaskId',
        'setViewDeleteTask',
        'closeViewTask'
    ];


    public function loadPosts()
    {
        $this->readyToLoad = true;
    }

    public function render()
    {
        $this->getDateExpiration();
        $this->getDateRemindMe();
        // $this->newComment = $this->readyToLoad ?
        //     Task::find($this->getId)->content :
        //     [];

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
    }

    public function getTaskId($task, $action = 'show')
    {
        $this->getId = $task;
        $this->action = $action;
    }

    public function getDateExpiration($time_interval = null)
    {
        if ($time_interval) {
            if ($time_interval == 'selected_date_expiration') {
                $this->typeDateSelected = $this->typeDateSelected == 'selected_date_expiration' ? '' : 'selected_date_expiration';
            } else {
                $date = Carbon::now();
                switch ($time_interval) {
                    case 'today':
                        $year = $date->isoFormat('YYYY');
                        $month = $date->isoFormat('MM');
                        $day = $date->isoFormat('DD');
                        break;
                    case 'tomorrow':
                        $year = $date->isoFormat('YYYY');
                        $month = $date->isoFormat('MM');
                        $day = $date->addDay(1)->isoFormat('DD');
                        break;
                    case 'next_week':
                        $year = $date->isoFormat('YYYY');
                        $month = $date->isoFormat('MM');
                        $day = $date->addDay(7)->isoFormat('DD');
                        break;
                    default:

                        break;
                }

                $hour = '23';
                $minute = '59';
                $second = '59';
                $this->dateExpiration = Carbon::create($year, $month, $day, $hour, $minute, $second);
                $this->typeDateSelected = $time_interval;
            }
        }
    }

    public function closeDateExpiration()
    {
        $this->typeDateSelected = "";
        $this->dateExpiration = "";
    }

    public function saveDateExpiration(Task $task)
    {
        $task->date_expiration = $this->dateExpiration;
        $task->save();
        $this->emitTo('to-do.board-show', '$refresh');
        $this->closeDateExpiration();

        $notificaction = Notification::where('notifiable_type', 'App\Models\User')
            ->where('notifiable_id',auth()->user()->id)
            ->whereJsonContains('data->task_id',$task->id)
            ->get();

        if($notificaction->count() > 0){
            $notificaction = $notificaction->first();
            if ($notificaction->read_at && $task->date_expiration->isoFormat('YYYY-MM-DDTHH:mm') > now()->isoFormat('YYYY-MM-DDTHH:mm')) {
                $notificaction->read_at = null;
            }
            // Accede al campo JSON y modifícalo
            $data = $notificaction->data;

            // Decodificar la cadena JSON en un array asociativo
            $data = json_decode($data, true);

            // Realiza las modificaciones necesarias
            $data['date_expiration'] = $task->date_expiration->isoFormat('YYYY-MM-DDTHH:mm');

            // Codificar el array asociativo como una cadena JSON
            $data = json_encode($data);

            // Asigna los datos actualizados al campo JSON
            $notificaction->data = $data;

            // Guarda el modelo para persistir los cambios
            $notificaction->save();
        }else{
            $data=[
                'task_id' => $task->id,
                'title' => $task->title,
                'remember_me' => $task->date_remind_me == null ? null : $task->date_remind_me->isoFormat('YYYY-MM-DDTHH:mm'),
                'date_expiration' => $task->date_expiration == null ? null : $task->date_expiration->isoFormat('YYYY-MM-DDTHH:mm'),
                'status' => $task->status
            ];

            auth()->user()->notify(new DesktopNotification($data));
        }
    }

    public function romoveDateExpiration(Task $task)
    {
        $task->date_expiration = null;
        $task->save();
        $this->emitTo('to-do.board-show', '$refresh');
        $this->closeDateExpiration();
    }



    public function getDateRemindMe($time_interval = null)
    {
        if ($time_interval) {
            if ($time_interval == 'selected_date_remind_me') {
                $this->typeDateRemindMeSelected = $this->typeDateRemindMeSelected == 'selected_date_remind_me' ? '' : 'selected_date_remind_me';
            } else {
                $date = Carbon::now();
                switch ($time_interval) {
                    case 'morning':
                        $hour = '7';
                        break;
                    case 'afternoon':
                        $hour = '14';
                        break;
                    case 'night':
                        $hour = '20';
                        break;
                    default:
                        $hour = '7';
                        break;
                }

                $year = $date->isoFormat('YYYY');
                $month = $date->isoFormat('MM');
                $day = $date->isoFormat('DD');
                $minute = '00';
                $second = '00';

                $this->dateRemindMe = Carbon::create($year, $month, $day, $hour, $minute, $second);
                $this->typeDateRemindMeSelected = $time_interval;
                // dd($this->dateRemindMe, $this->typeDateRemindMeSelected);
            }
        }
    }

    public function romoveDateRemindMe(Task $task)
    {
        $task->date_remind_me = null;
        $task->save();
        $this->emitTo('to-do.board-show', '$refresh');
        $this->closeDateExpiration();
    }

    public function closeDateRemindMe()
    {
        $this->typeDateRemindMeSelected = "";
        $this->dateRemindMe = "";
    }

    public function saveDateRemindMe(Task $task)
    {
        $task->date_remind_me = $this->dateRemindMe;
        $task->save();
        $this->emitTo('to-do.board-show', '$refresh');
        $this->closeDateRemindMe();


        $notificaction = Notification::where('notifiable_type', 'App\Models\User')
                    ->where('notifiable_id',auth()->user()->id)
                    ->whereJsonContains('data->task_id',$task->id)
                    ->get();

        if($notificaction->count() > 0){
            $notificaction = $notificaction->first();
            // Accede al campo JSON y modifícalo
            $data = $notificaction->data;

            // Decodificar la cadena JSON en un array asociativo
            $data = json_decode($data, true);

            // Realiza las modificaciones necesarias
            $data['remember_me'] = $task->date_remind_me->isoFormat('YYYY-MM-DDTHH:mm');

            // Codificar el array asociativo como una cadena JSON
            $data = json_encode($data);

            // Asigna los datos actualizados al campo JSON
            $notificaction->data = $data;

            // Guarda el modelo para persistir los cambios
            $notificaction->save();
        }else{
            $data=[
                'task_id' => $task->id,
                'title' => $task->title,
                'remember_me' => $task->date_remind_me == null ? null : $task->date_remind_me->isoFormat('YYYY-MM-DDTHH:mm'),
                'date_expiration' => $task->date_expiration == null ? null : $task->date_expiration->isoFormat('YYYY-MM-DDTHH:mm'),
                'status' => $task->status
            ];

            auth()->user()->notify(new DesktopNotification($data));
        }

    }

    public function addToday(Task $task)
    {
        // dd('hola');
        $date = Carbon::now();
        $year = $date->isoFormat('YYYY');
        $month = $date->isoFormat('MM');
        $day = $date->isoFormat('DD');

        $task->date_my_day = $task->date_my_day ? null : Carbon::create($year, $month, $day, '23', '59', '59');
        $task->save();
        $this->emitTo('to-do.board-show', '$refresh');
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

    public function delteStep(StepTask $step)
    {
        $step->delete();
        $this->emitTo('to-do.board-show', '$refresh');
    }

    public function saveStep($id)
    {
        if (strlen($this->newStep) > 0) {
            StepTask::create([
                'name' => $this->newStep,
                'complete' => false,
                'task_id' => $id
            ]);
            $this->emitTo('to-do.board-show', '$refresh');
            $this->newStep = "";
        }
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



    /**
     * title: Recibe la tarea a eliminar
     * Descripción: Recibe la tarea que se desea eliminar
     * @access public
     * @param  $task integer
     * @author Cristian Milton Fidel Pascual <al221710403@gmail.com>
     * @date 2023-02-07 22:08:54
     */
    public function setViewDeleteTask(Task $task)
    {
        if ($task->children->count() > 0) {
            foreach ($task->children as $subtask) {
                $this->deleteTask($subtask->id);
            }
        }
        $this->deleteTask($task->id);
        $this->emit('noty-primary', 'Tarea eliminada correctamente');
        $this->emitTo('to-do.task-index-controller', '$refresh');
        $this->emitTo('to-do.board-show', '$refresh');
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
        // dd($task);
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

    // public function addFiles($id)
    // {
    //     $task = Task::find($id);
    //     $this->old_files = $task->files;
    //     dd($this->old_files);
    //     $this->modal_files = true;
    // }

    public function saveFiles($id)
    {
        // dd($this->files);
        $this->uploadFiles($this->files, 'todo/task/files', 'App\Models\ToDo\Task', $id);
        $this->reset('files');
        $this->emitTo('to-do.board-show', '$refresh');
    }
}
