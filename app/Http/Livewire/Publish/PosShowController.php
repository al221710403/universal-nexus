<?php

namespace App\Http\Livewire\Publish;

use Livewire\Component;
use App\Models\Publish\Post;

class PosShowController extends Component
{
    public $post;

    public function mount($post)
    {
        $this->post = Post::firstWhere('slug', $post);
    }
    public function render()
    {
        $tags = $this->post->tags;

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
