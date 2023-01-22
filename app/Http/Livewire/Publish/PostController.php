<?php

namespace App\Http\Livewire\Publish;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Publish\Tag;
use Illuminate\Support\Str;
use App\Models\Publish\Post;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PostController extends Component
{
    use WithFileUploads;
    use WithPagination;

    // modals
    public $settings = false, $published_modal = false, $preview_modal = false, $labelAction = "New Post";

    public $tags, $old_tags, $all_tags;

    // Varibles del post
    public $post,
        $post_id,
        $title,
        $body,
        $featured_image,
        $featured_image_caption,
        $published,
        $publish_date;

    protected $listeners =  [
        'deletePost' => 'deletePost'
    ];

    public function mount($id = 0)
    {
        if ($id == 0) {
            $new_post = Post::whereNull('title')
                ->whereNull('body')->first();
            if (!$new_post) {
                $new_post = Post::create([
                    "author_id" => Auth::user()->id
                ]);
                $new_post->slug = "new-post-" . $new_post->id;
                $new_post->save();
            }
            $this->post_id = $new_post->id;
        } else {
            $this->post_id = $id;
        }
        $this->getPost();

        $this->all_tags = Tag::all('name')->pluck('name')->toArray();
    }

    public function render()
    {

        return view('livewire.publish.post.create');
    }

    public function save()
    {
        $this->post->update([
            "title" => $this->title,
            "body" => $this->body
        ]);

        if (strlen($this->title) > 0) {
            $this->post->slug = $this->createSlug();
            $this->post->save();
        }

        $this->emit('noty-primary', 'Cambios guardados');
    }


    public function createSlug()
    {
        $slug = Str::slug($this->post->title);
        $slugExist = Post::where('slug', $slug)->where('id', '!=', $this->post->id)->first();

        if ($slugExist) {
            $max = Post::where('title', $this->post->title)->count();
            $max = $max == 0 ? 1 : $max + 1;
            return $slug . '-' . $max;
        } else {
            return $slug;
        }
    }

    public function saveSetting()
    {

        $this->addTags();

        $path = 'publish/post/';
        if ($this->featured_image) {
            if ($this->post->featured_image != null) {
                if (file_exists('storage/' .  $this->post->featured_image)) {
                    unlink('storage/' . $this->post->featured_image); //si el archivo ya existe se borra
                }
            }

            $customFileName = uniqid() . '_.' . $this->featured_image->extension();
            $this->featured_image->storeAs('public/' . $path, $customFileName);
            $this->post->featured_image = $path . $customFileName;
        }


        $this->post->featured_image_caption = $this->featured_image_caption;
        $this->post->publish_date = $this->publish_date;
        $this->post->save();
        $this->featured_image = '';
        $this->settings = false;

        $this->getPost();

        $this->emit('noty-primary', 'Configiración guardada');
    }

    public function publishedPost($action)
    {
        $this->save();
        if (strlen($this->title) > 0 && strlen($this->body) > 0) {
            $this->post->published = true;
            $this->post->publish_date = $action ? Carbon::now()->timestamp : $this->publish_date;
            $this->post->save();
            $this->published_modal = false;
            $this->emit('noty-primary', 'Post publicado');
            return redirect()->route('publish.posts.index');
        } else {
            $this->published_modal = false;
            $this->emit('noty-danger', 'No se puede publicar un post vacío');
        }
    }

    public function deletePost()
    {
        DB::beginTransaction();
        try {

            if (file_exists('storage/' .  $this->post->featured_image)) {
                unlink('storage/' . $this->post->featured_image); //si el archivo ya existe se borra
            }
            $this->post->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $this->emit('noty-danger', 'Ups!! Hubo un error al eliminar el post');
            return $e->getMessage();
        }

        return redirect()->route('publish.posts.index');
    }


    public function getPost()
    {
        $this->post = Post::find($this->post_id);
        $this->title = $this->post->title;
        $this->body = $this->post->body;
        $this->published = $this->post->published;
        $this->publish_date = $this->post->publish_date->format('Y-m-d\TH:i');
        // $this->featured_image = $this->post->featured_image;
        $this->featured_image_caption = $this->post->featured_image_caption;

        $this->labelAction = $this->published ? "Editar Post" : "New Post";

        $this->old_tags = $this->post->tags->pluck('name')->toArray();
        $this->all_tags = Tag::all('name')->pluck('name')->toArray();
    }

    public function addTags()
    {
        foreach ($this->tags as $item) {
            $tag = Tag::firstOrCreate([
                'name' => ucwords(strtolower($item)),
            ]);

            if ($this->post->tags()->where('tag_id', $tag->id)->count() == 0) {
                $this->post->tags()->attach($tag->id);
                $tag->used = $tag->used + 1;
                $tag->save();
            }
        }

        $deleteTags = array_diff($this->old_tags, $this->tags);
        foreach ($deleteTags as $item) {
            $tag = Tag::firstWhere('name', $item);
            if ($tag) {
                $this->post->tags()->detach($tag->id);
                $tag->used = $tag->used == 0 ? $tag->used : $tag->used - 1;
                $tag->save();
            } else {
                $this->emit('noty-danger', 'Ups!! Hubo un error al eliminar el tag: ' . $item);
            }
        }
    }
}
