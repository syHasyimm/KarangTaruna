<?php

namespace App\Livewire\Voting;

use App\Models\Event;
use Livewire\Component;

class Index extends Component
{
    // Admin form
    public string $title = '';
    public string $description = '';
    public string $year = '';
    public string $status = 'draft';
    public bool $showForm = false;
    public ?int $editingId = null;

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'year' => 'required|digits:4',
        'status' => 'required|in:draft,open,closed',
    ];

    public function mount()
    {
        $this->year = now()->year;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'description' => $this->description,
            'year' => $this->year,
            'status' => $this->status,
        ];

        if ($this->editingId) {
            Event::findOrFail($this->editingId)->update($data);
            session()->flash('success', 'Voting berhasil diperbarui.');
        } else {
            Event::create($data);
            session()->flash('success', 'Voting berhasil dibuat.');
        }

        $this->resetForm();
    }

    public function edit($id)
    {
        $event = Event::findOrFail($id);
        $this->editingId = $event->id;
        $this->title = $event->title;
        $this->description = $event->description ?? '';
        $this->year = $event->year;
        $this->status = $event->status;
        $this->showForm = true;
    }

    public function delete($id)
    {
        Event::findOrFail($id)->delete();
        session()->flash('success', 'Voting berhasil dihapus.');
    }

    public function resetForm()
    {
        $this->reset(['title', 'description', 'status', 'showForm', 'editingId']);
        $this->year = now()->year;
    }

    public function render()
    {
        return view('livewire.voting.index', [
            'events' => Event::withCount('votes')->latest()->get(),
        ]);
    }
}
