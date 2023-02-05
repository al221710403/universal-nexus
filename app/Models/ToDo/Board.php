<?php

namespace App\Models\ToDo;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Board extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }


    public function scopeAuthor($query, $id = null)
    {
        if ($id) {
            return $query->where('author_id', $id);
        } else {
            return $query->where('author_id', Auth::user()->id);
        }
    }

    public function scopeTask($query)
    {
        return $query->author()->where('name', 'Tareas');
    }

    public function scopeBoard($query, $id = null)
    {
        if ($id) {
            return $query->where('id', $id);
        } else {
            return;
        }
    }
}
