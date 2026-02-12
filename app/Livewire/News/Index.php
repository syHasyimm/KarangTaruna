<?php

namespace App\Livewire\News;

use App\Models\News;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class Index extends Component
{
    use WithPagination, WithFileUploads;

    public string $title = '';
    public string $content = '';
    public $thumbnail;
    public bool $showForm = false;
    public ?int $editingId = null;

    protected $rules = [
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'thumbnail' => 'nullable|image|max:2048',
    ];

    public function save()
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'content' => $this->content,
        ];

        if ($this->thumbnail) {
            $data['thumbnail'] = $this->thumbnail->store('news', 'public');
        }

        if ($this->editingId) {
            News::findOrFail($this->editingId)->update($data);
            session()->flash('success', 'Berita berhasil diperbarui.');
        } else {
            News::create($data);
            session()->flash('success', 'Berita berhasil dipublikasikan.');
        }

        $this->resetForm();
    }

    public function edit($id)
    {
        $news = News::findOrFail($id);
        $this->editingId = $news->id;
        $this->title = $news->title;
        $this->content = $news->content;
        $this->showForm = true;
    }

    public function delete($id)
    {
        News::findOrFail($id)->delete();
        session()->flash('success', 'Berita berhasil dihapus.');
    }

    public function resetForm()
    {
        $this->reset(['title', 'content', 'thumbnail', 'showForm', 'editingId']);
    }

    public function render()
    {
        return view('livewire.news.index', [
            'newsList' => News::latest()->paginate(9),
        ]);
    }
}
