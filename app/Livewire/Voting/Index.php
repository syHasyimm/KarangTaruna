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
    public string $type = 'yes_no';
    public array $options = ['', '', '', '', ''];
    public bool $showForm = false;
    public ?int $editingId = null;

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'year' => 'required|digits:4',
        'status' => 'required|in:draft,open,closed',
        'type' => 'required|in:yes_no,multiple_choice',
        'options' => 'array',
        'options.*' => 'nullable|string|max:255',
    ];

    public function mount()
    {
        $this->year = now()->year;
    }

    public function save()
    {
        $this->validate();

        // Filter empty options
        $cleanedOptions = array_values(array_filter($this->options, fn($value) => !is_null($value) && $value !== ''));
        
        if ($this->type === 'multiple_choice' && count($cleanedOptions) < 2) {
            $this->addError('options', 'Minimal 2 pilihan opsi harus diisi untuk multiple choice.');
            return;
        }

        $data = [
            'title' => $this->title,
            'description' => $this->description,
            'year' => $this->year,
            'status' => $this->status,
            'type' => $this->type,
            'options' => $this->type === 'multiple_choice' ? $cleanedOptions : null,
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
        $this->type = $event->type;
        // Fill options or default to 5 empty strings
        $this->options = array_pad($event->options ?? [], 5, '');
        $this->showForm = true;
    }

    public function delete($id)
    {
        Event::findOrFail($id)->delete();
        session()->flash('success', 'Voting berhasil dihapus.');
    }

    public function resetForm()
    {
        $this->reset(['title', 'description', 'status', 'type', 'options', 'showForm', 'editingId']);
        $this->options = ['', '', '', '', '']; // Reset array explicitly
        $this->year = now()->year;
    }

    public function render()
    {
        return view('livewire.voting.index', [
            'events' => Event::withCount('votes')->latest()->get(),
        ]);
    }
}
