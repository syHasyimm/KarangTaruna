<?php

namespace App\Livewire\Admin;

use App\Models\Chairman;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;

class ChairmanManagement extends Component
{
    use WithFileUploads, WithPagination;

    public string $name = '';
    public string $birth_place = '';
    public ?string $birth_date = null;
    public string $period = '';
    public $photo = null;
    public bool $is_active = true;
    public int $sort_order = 0;
    public array $achievements = [''];
    public bool $showForm = false;
    public ?int $editingId = null;

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'birth_place' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date',
            'period' => 'required|string|max:100',
            'photo' => $this->editingId ? 'nullable|image|max:2048' : 'nullable|image|max:2048',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
            'achievements' => 'array',
            'achievements.*' => 'nullable|string|max:255',
        ];
    }

    public function addAchievement()
    {
        $this->achievements[] = '';
    }

    public function removeAchievement($index)
    {
        unset($this->achievements[$index]);
        $this->achievements = array_values($this->achievements);
        if (empty($this->achievements)) {
            $this->achievements = [''];
        }
    }

    public function save()
    {
        $this->validate();

        // Filter out empty achievements
        $filteredAchievements = array_values(array_filter($this->achievements, fn($a) => trim($a) !== ''));

        $data = [
            'name' => $this->name,
            'birth_place' => $this->birth_place ?: null,
            'birth_date' => $this->birth_date ?: null,
            'period' => $this->period,
            'achievements' => $filteredAchievements ?: null,
            'is_active' => $this->is_active,
            'sort_order' => $this->sort_order,
        ];

        if ($this->photo) {
            if ($this->editingId) {
                $chairman = Chairman::find($this->editingId);
                if ($chairman && $chairman->photo) {
                    Storage::disk('public')->delete($chairman->photo);
                }
            }
            $data['photo'] = $this->photo->store('chairmans', 'public');
        }

        if ($this->editingId) {
            Chairman::findOrFail($this->editingId)->update($data);
            session()->flash('success', 'Data ketua berhasil diperbarui.');
        } else {
            Chairman::create($data);
            session()->flash('success', 'Data ketua berhasil ditambahkan.');
        }

        $this->resetForm();
    }

    public function edit($id)
    {
        $chairman = Chairman::findOrFail($id);
        $this->editingId = $chairman->id;
        $this->name = $chairman->name;
        $this->birth_place = $chairman->birth_place ?? '';
        $this->birth_date = $chairman->birth_date?->format('Y-m-d');
        $this->period = $chairman->period;
        $this->is_active = $chairman->is_active;
        $this->sort_order = $chairman->sort_order;
        $this->achievements = $chairman->achievements ?: [''];
        $this->photo = null;
        $this->showForm = true;
    }

    public function delete($id)
    {
        $chairman = Chairman::findOrFail($id);
        if ($chairman->photo) {
            Storage::disk('public')->delete($chairman->photo);
        }
        $chairman->delete();
        session()->flash('success', 'Data ketua berhasil dihapus.');
    }

    public function resetForm()
    {
        $this->reset(['name', 'birth_place', 'birth_date', 'period', 'photo', 'is_active', 'sort_order', 'achievements', 'showForm', 'editingId']);
        $this->is_active = true;
        $this->sort_order = 0;
        $this->achievements = [''];
    }

    public function render()
    {
        return view('livewire.admin.chairman-management', [
            'chairmans' => Chairman::ordered()->paginate(10),
        ]);
    }
}
