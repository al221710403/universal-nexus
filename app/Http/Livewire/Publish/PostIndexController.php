<?php

namespace App\Http\Livewire\Publish;

use App\Models\User;
use Spatie\Tags\Tag;
use Livewire\Component;
use App\Traits\PostTrait;
use Illuminate\Support\Str;
use App\Models\Publish\Post;
use Livewire\WithPagination;
use App\Models\Publish\Image;
use TeamTNT\TNTSearch\TNTSearch;
use Illuminate\Support\Facades\DB;

class PostIndexController extends Component
{
    use WithPagination;
    use PostTrait;

    // Variables utilizadas en el index
    public $search, $column, $order, $pagination, $authors_select, $author_id, $tags_select, $tags = [], $filters = false, $my_posts = false, $search_post = false;

    // Variables utilizadas en el modal de mis post
    public $searchMyPost, $my_column, $my_order, $my_pagination, $status;

    protected $listeners =  [
        'deleteMyPost' => 'deleteMyPost'
    ];

    public function mount()
    {
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
        $this->tags_select = Tag::all('id', 'name')->sortBy('name');

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

        $posts = Post::tagsSearch($this->tags)
            ->authorSearch($this->author_id)
            ->live()
            ->public()
            ->orderBy($this->column, $this->order)
            ->paginate($this->pagination);

        return view('livewire.publish.post.index', compact("posts", "all_post"));
    }


    public function getResultsProperty(){
        $posts = Post::search( $this->search)
        ->orderBy('title', 'asc')
        ->paginate(5);
        $tnt = new TNTSearch;
        $se = $this->search;

        return $posts->map(function($post) use ($se, $tnt) {
            $post->title = $tnt->highlight($post->title, $se, 'span',['tagOptions' => ['class' => 'search-term']]);
            $post->body = $tnt->highlight($post->body, $se, 'span',['tagOptions' => ['class' => 'search-term']]);
            $post->metadata = $tnt->highlight($post->metadata, $se, 'span',['tagOptions' => ['class' => 'search-term']]);
            return $post; // Asegúrate de devolver el objeto $post después de aplicar la transformación
        });
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
        if ($this->deletePostTrait($id)) {
            $this->emit('noty-primary', 'La publicación se elimino correctamente');
        } else {
            $this->emit('noty-danger', 'Ups!! Hubo un error al eliminar la publicación');
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

}
