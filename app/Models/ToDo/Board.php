<?php

namespace App\Models\ToDo;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Board extends Model
{
    use HasFactory;

    static protected $nameBoard = "Tareas";

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    protected $appends = ['is_tasks'];

    // ==================================================================
    // FUNCIONES: métodos static del tablero
    // =================================================================

    // Crea el tablero tareas
    public static function createBoard()
    {
        $board = Board::select('id')->author()->where('name', self::$nameBoard)->first();
        if ($board === null) {
            $newBoard = Board::create([
                'name' => self::$nameBoard,
                'author_id' => Auth::user()->id
            ]);

            return $newBoard;
        }
        return null;
    }

    // Elimina el tablero
    public static function deleteBoard($id)
    {
        $board = Board::find($id);
        if ($board != null) {
            DB::beginTransaction();
            try {
                //Se elimina la imagen de fondo si existe
                if ($board->background_location == 'local' && !$board->background_default) {
                    if (file_exists('storage/' .  $board->background_image)) {
                        unlink('storage/' . $board->background_image); //si el archivo ya existe se borra
                    }
                }

                // Eliminar colaboradores
                if ($board->collaborators->count() > 0) {
                    $board->collaborators()->detach();
                }

                // Eliminar tareas
                if ($board->tasks->count() > 0) {
                    foreach ($board->tasks as $task) {
                        Task::getTaskToDelete($task->id);
                    }
                }

                // Elimina board
                $board->delete();

                DB::commit();
                return true;
            } catch (\Exception $e) {
                DB::rollback();
                return $e->getMessage();
            }
        }
        return false;
    }

    public static function getPrueba($param)
    {
        return $param;
    }

    // ==================================================================
    // FIN DE FUNCIONES static
    // =================================================================


    /**
     * The collaborators board.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function collaborators()
    {
        return $this->belongsToMany(User::class, 'collaborators_boards')->withPivot('permissions');
    }

    public function getIsTasksAttribute()
    {
        $asigned = false;

        $MyBoard = Board::select('id')->author()->task()->first();

        if ($MyBoard->count() > 0) {
            $asigned = $this->id == $MyBoard->id ? true : false;
        }

        return $asigned;
    }

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
