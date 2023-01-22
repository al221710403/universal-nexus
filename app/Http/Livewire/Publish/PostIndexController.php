<?php

namespace App\Http\Livewire\Publish;

use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use App\Models\Publish\Tag;
use App\Models\Publish\Post;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class PostIndexController extends Component
{
    use WithPagination;

    public $search, $column, $order, $pagination, $authors_select, $author_id, $tags_select, $tags = [], $filters = false, $my_posts = false;

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
        $this->tags_select = Tag::orderBy('name')->get();

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

        // dd($this->all_post);


        if (strlen($this->search) > 0) {
            $posts = Post::where('title', 'like', '%' . $this->search . '%')->tagsf($this->tags)->live()
                ->author($this->author_id)
                ->orderBy($this->column, $this->order)
                ->paginate($this->pagination);
        } else {
            $posts = Post::tagsf($this->tags)->live()->author($this->author_id)
                ->orderBy($this->column, $this->order)
                ->paginate($this->pagination);
        }

        // dd($posts[0]->featured_image);
        // dd($posts);
        return view('livewire.publish.post.index', compact("posts", "all_post"));
    }

    public function clearAll()
    {
        $this->column = 'publish_date';
        $this->order = 'desc';
        $this->author_id = "";
        $this->tags = [];
        $this->search = "";
        $this->pagination = 8;
    }

    public function saveFilters()
    {
        $this->filters = false;
    }

    public function getTags($id)
    {
        $this->tags = [$id];
    }

    public function deleteMyPost($id)
    {
        $post = Post::find($id);
        // dd($post);
        DB::beginTransaction();
        try {

            if (file_exists('storage/' .  $post->featured_image)) {
                unlink('storage/' . $post->featured_image); //si el archivo ya existe se borra
            }
            $post->delete();
            DB::commit();
            $this->emit('noty-primary', 'El post se elimino correctamente');
        } catch (\Exception $e) {
            DB::rollback();
            $this->emit('noty-danger', 'Ups!! Hubo un error al eliminar el post');
            return $e->getMessage();
        }

        return redirect()->route('publish.posts.index');
    }
}
