<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Blog;

class BlogsPage extends Component
{
    public $posts;

    public $searchTitle = ''; 
    
     public $blogs;

public function mount()
{
      $this->blogs = Blog::orderBy('fecha', 'desc')->get();
}

    public function render()
    {
         $blogs = Blog::query()
            ->when($this->searchTitle, function ($query) {
                $query->where('titulo_blog', 'like', '%' . $this->searchTitle . '%');
            })
            ->orderBy('fecha', 'desc')
            ->get();

        return view('livewire.blogs-page', compact('blogs'));
    }
}
