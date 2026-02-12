<?php

namespace App\Livewire\News;

use App\Models\News;
use Livewire\Component;

class Show extends Component
{
    public News $news;

    public function mount(News $news)
    {
        $this->news = $news;
    }

    public function render()
    {
        return view('livewire.news.show');
    }
}
