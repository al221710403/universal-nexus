<?php

namespace App\Models\ToDo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StepTask extends Model
{
    use HasFactory;

    /**
     * The table assigned.
     *
     * @var string
     */
    protected $table = "steps_task";

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
}
