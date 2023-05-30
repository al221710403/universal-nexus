<?php

namespace App\Http\Livewire\Publish;

use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use App\Models\Tag;
use App\Models\Publish\Post;
use Livewire\WithPagination;
use App\Models\Publish\Image;
use Illuminate\Support\Facades\DB;

class PostIndexController extends Component
{
    use WithPagination;

    // Variables utilizadas en el index
    public $search, $column, $order, $pagination, $authors_select, $author_id, $tags_select, $tags = [], $filters = false, $my_posts = false;

    // Variables utilizadas en el modal de mis post
    public $searchMyPost, $my_column, $my_order, $my_pagination, $status;

    protected $listeners =  [
        'deleteMyPost' => 'deleteMyPost'
    ];

    public function mount()
    {
        $new = Post::find(2);

        // $new->detachTags(['tag6']);
        $new->attachTags(['tag4', 'tag5'], 'Post');

        $this->column = 'publish_date';
        $this->order = 'desc';
        $this->pagination = 8;

        $this->my_column = 'publish_date';
        $this->my_order = 'desc';
        $this->my_pagination = 10;
        $this->status = 'all';
    }

    public function render()
    {
        $this->authors_select = User::all();
        $this->tags_select = Tag::orderBy('name')->get();

        // Buscador del modal de mis post
        if (strlen($this->searchMyPost) > 0) {
            $all_post = Post::where('title', 'like', '%' . $this->searchMyPost . '%')
                ->mypost()
                ->status($this->status)
                ->orderBy($this->my_column, $this->my_order)
                ->paginate($this->my_pagination);
        } else {
            $all_post = Post::mypost()
                ->status($this->status)
                ->orderBy($this->my_column, $this->my_order)
                ->paginate($this->my_pagination);
        }

        // Buscador del index
        if (strlen($this->search) > 0) {
            $posts = Post::where('title', 'like', '%' . $this->search . '%')
                ->tagsf($this->tags)
                ->live()
                ->public()
                ->author($this->author_id)
                ->orderBy($this->column, $this->order)
                ->paginate($this->pagination);
        } else {
            $posts = Post::tagsf($this->tags)
                ->live()
                ->public()
                ->author($this->author_id)
                ->orderBy($this->column, $this->order)
                ->paginate($this->pagination);
        }


        return view('livewire.publish.post.index', compact("posts", "all_post"));
    }

    /**
     * title: Delete Post
     * Descripción: Borra el post seleccionados
     * @access public
     * @param  int $id
     * @return mesaggess
     * @author Cristian Milton Fidel Pascual <al221710403@gmail.com>
     * @date 2023-01-25 19:22:40
     */
    public function deleteMyPost($id)
    {
        $post = Post::find($id);
        $tags = $post->tags;

        DB::beginTransaction();
        try {
            // Elimina los tags asociados al post
            if ($tags->count() > 0) {
                $post->tags()->detach($tags->pluck('id')->toArray());
            }

            // Elimina la imagen
            if ($post->featured_image != 'noimg.png') {
                if (file_exists('storage/' .  $post->featured_image)) {
                    unlink('storage/' . $post->featured_image); //si el archivo ya existe se borra
                }
            }

            // Eliminamos las imagenes del post
            $images = $this->extractImage($post->body);
            $path = 'publish/post/image/';
            $deleteImage = [];

            // Crea un nuevo array agregando el path completo a las imagenes
            foreach ($images as $image) {
                $image_url = $path . pathinfo($image, PATHINFO_BASENAME);
                array_push($deleteImage, $image_url);
            }
            $this->deleteImage($deleteImage);

            $post->delete();

            DB::commit();
            $this->emit('noty-primary', 'El post se elimino correctamente');
        } catch (\Exception $e) {
            DB::rollback();
            $this->emit('noty-danger', 'Ups!! Hubo un error al eliminar el post');
            return $e->getMessage();
        }
    }

    /**
     * title: Clear del index
     * Descripción: Función que resetea las variables utilizdas
     * @access public
     * @author Cristian Milton Fidel Pascual <al221710403@gmail.com>
     * @date 2023-01-25 19:19:07
     */
    public function clearAll()
    {
        $this->column = 'publish_date';
        $this->order = 'desc';
        $this->author_id = "";
        $this->tags = [];
        $this->search = "";
        $this->pagination = 8;
    }

    /**
     * title: SaveFilters
     * Descripción: Cierra el modal de filtros
     * @access public
     * @return booleand
     * @author Cristian Milton Fidel Pascual <al221710403@gmail.com>
     * @date 2023-01-25 19:21:04
     */
    public function saveFilters()
    {
        $this->filters = false;
    }

    /**
     * title: Filtro del tag
     * Descripción: Función utilizada para el filtro por tag
     * @access public
     * @param  int $id del tag
     * @return Array del tag
     * @author Cristian Milton Fidel Pascual <al221710403@gmail.com>
     * @date 2023-01-25 19:23:50
     */
    public function getTags($id)
    {
        $this->tags = [$id];
    }


    //==================================================
    // Funciones de images utilizadas en el post


    /**
     * title: Extrae las imagenes
     * Descripción: Extrae las imagenes incrustadas en el post con regex
     * @access public
     * @param  string $data
     * @return array $matches
     * @author Cristian Milton Fidel Pascual <al221710403@gmail.com>
     * @date 2023-01-26 00:04:56
     */
    public function extractImage($data)
    {
        $re_extract_image = '/src=["\']([^ ^"^\']*)["\']/ims';
        preg_match_all($re_extract_image, $data, $matches);
        return $matches[1];
    }

    /**
     * title: Elimina las imagenes
     * Descripción: Elimina las imagenes que se incrustan dentro del post
     * @access public
     * @param  array $images
     * @return message
     * @author Cristian Milton Fidel Pascual <al221710403@gmail.com>
     * @date 2023-01-26 00:03:25
     */
    public function deleteImage($images)
    {
        foreach ($images as $delete) {
            $file = Image::where('image_url', $delete)->first();
            if ($file) {
                DB::beginTransaction();
                try {
                    if (file_exists('storage/' .  $delete)) {
                        unlink('storage/' . $delete); //si el archivo ya existe se borra
                    }
                    $file->delete();
                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollback();
                    $this->emit('noty-danger', 'Ups!! Hubo un error al eliminar la imagen física');
                    return $e->getMessage();
                }
            }
        }
    }
}
