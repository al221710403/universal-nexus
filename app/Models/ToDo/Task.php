<?php

namespace App\Models\ToDo;

use App\Models\User;
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
        'collaborators'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    public $dates = [
        'date_expiration',
        'created_at',
        'updated_at',
    ];


    public function getIsTodayAttribute()
    {
        $asigned = false;

        if ($this->date_expiration) {
            $asigned = $this->date_expiration->format('Y-m-d') == now()->format('Y-m-d') ? true : false;
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

    public function parent()
    {
        return $this->belongsTo(Task::class, 'task_id');
    }

    public function children()
    {
        return $this->hasMany(Task::class);
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
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function collaborators()
    {
        return $this->hasMany(CollaboratorTasks::class);
    }


    public function scopeToday($query)
    {
        return $query->whereDate('date_expiration', '=', now()->format('Y-m-d'));
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
