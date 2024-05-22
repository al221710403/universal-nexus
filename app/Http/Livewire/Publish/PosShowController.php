<?php

namespace App\Http\Livewire\Publish;

use Livewire\Component;
use App\Models\Publish\Post;

class PosShowController extends Component
{
    public $post,$keywords;

    public function mount($post)
    {
        $this->post = Post::firstWhere('slug', $post);
    }
    public function render()
    {
        $tags = $this->post->tags;

        $data_json = json_decode($this->post->metadata, true);
        $this->keywords = $data_json["keywords"] ?? [];

        if ($tags->count() > 0) {
            $similares = Post::where('id', '!=', $this->post->id)
                ->tagsSearch($tags->pluck('id')->toArray())
                ->published()
                ->latest('id')
                ->take(6)
                ->get();
        } else {
            $similares = Post::where('id', '!=', $this->post->id)
                ->live()
                ->latest('id')
                ->take(6)
                ->get();
        }

        return view('livewire.publish.post.show', compact('similares'));
    }
}
