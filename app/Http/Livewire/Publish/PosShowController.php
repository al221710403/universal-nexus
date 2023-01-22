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
        return view('livewire.publish.pos-show-controller');
    }
}
