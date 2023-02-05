<?php

namespace App\Models\ToDo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollaboratorTasks extends Model
{
    use HasFactory;

    protected $table = "collaborators_tasks";
}
