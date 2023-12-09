<?php

namespace App\Models\ToDo;

use App\Models\File;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    protected $appends = ['is_today'];


    /**
     * The relationship counts that should be eager loaded on every query.
     *
     * @var array
     */
    protected $withCount = [
        'steps',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    public $dates = [
        'date_expiration',
        'date_remind_me',
        'date_my_day',
        'created_at',
        'updated_at',
    ];

    // ==================================================================
    // FUNCIONES: métodos static de la tarea
    // =================================================================

    // Obtienen  la tarea a eliminar
    public static function getTaskToDelete($id)
    {
        $task = Task::find($id);
        if ($task != null) {
            if ($task->children->count() > 0) {
                foreach ($task->children as $subtask) {
                    Task::deleteTask($subtask->id);
                }
            }
            Task::deleteTask($task->id);
            return true;
        }
        return false;
    }

    // Elimina la tarea
    public static function deleteTask($id)
    {
        $task = Task::find($id);
        if ($task != null) {
            DB::beginTransaction();
            try {
                // Eliminar colaboradores
                if ($task->collaborators->count() > 0) {
                    $task->collaborators()->detach();
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
                return true;
            } catch (\Exception $e) {
                DB::rollback();
                return $e->getMessage();
            }
        }
        return false;
    }

    // ==================================================================
    // FIN DE FUNCIONES static
    // =================================================================

    public function getIsTodayAttribute()
    {
        $asigned = false;

        if ($this->date_expiration) {
            $asigned = $this->date_expiration->format('Y-m-d') == now()->format('Y-m-d') ? true : false;
        }

        if ($this->status == 'Trabajando') {
            $asigned = true;
        }

        if ($this->date_my_day) {
            $asigned = $this->date_my_day->format('Y-m-d') == now()->format('Y-m-d') ? true : false;
        }

        return $asigned;
    }

    /**
     * The task author.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function authorTask()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Get the parent commentable model (post or video).
     */
    public function commentable()
    {
        return $this->morphTo();
    }

    public function parent()
    {
        return $this->morphOne(Task::class, 'taskable');
    }

    public function children()
    {
        return $this->morphMany(Task::class, 'taskable');
    }

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    /**
     * The septs task.
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function steps()
    {
        return $this->hasMany(StepTask::class);
    }

    /**
     * The collaborators task.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function collaborators()
    {
        return $this->belongsToMany(User::class, 'collaborators_tasks')->withPivot('permissions', 'assigned_task');
    }


    public function scopeToday($query)
    {
        return $query->where(function ($query) {
            $query->whereDate('date_expiration', '=', now()->format('Y-m-d'))
                ->orWhere('status', 'Trabajando')
                ->orWhereDate('date_my_day', '=', now()->format('Y-m-d'));
        });
    }

    public function scopeWorking($query)
    {
        return $query->orWhere('status', 'Trabajando');
    }

    public function scopeImportant($query)
    {
        return $query->where('priority', true);
    }

    public function scopeAuthor($query, $id = null)
    {
        if ($id) {
            return $query->where('author_id', $id);
        } else {
            return $query->where('author_id', Auth::user()->id);
        }
    }

    public function scopeSearch($query, $search = '')
    {

        return $query->author()->where('title', 'like', '%' . $search . '%');
    }

    public function scopeRetarded($query)
    {
        return $query->whereDate('date_expiration', '<', now()->format('Y-m-d'))->where('status', '!=', 'Completado');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'Pendiente');
    }

    public function scopeComplete($query)
    {
        return $query->where('status', 'Completado');
    }
}
