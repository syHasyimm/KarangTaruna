<?php

namespace App\Livewire\Admin;

use App\Models\Gallery;
use App\Models\GalleryCategory;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;

class GalleryManagement extends Component
{
    use WithFileUploads, WithPagination;

    // Gallery form
    public string $title = '';
    public string $description = '';
    public $photo = null;
    public int $sort_order = 0;
    public bool $is_active = true;
    public string $category_id = '';
    public bool $showForm = false;
    public ?int $editingId = null;

    // Category form
    public string $catName = '';
    public string $catColor = 'green';
    public bool $showCatForm = false;
    public ?int $editingCatId = null;

    // Filter
    public string $filterCategory = '';

    protected function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'photo' => $this->editingId ? 'nullable|image|max:2048' : 'required|image|max:2048',
            'sort_order' => 'integer|min:0',
            'is_active' => 'boolean',
            'category_id' => 'nullable|exists:gallery_categories,id',
        ];
    }

    protected $messages = [
        'photo.required' => 'Foto wajib diunggah.',
        'photo.image' => 'File harus berupa gambar (jpg, png, gif, webp).',
        'photo.max' => 'Ukuran foto maksimal 2MB.',
    ];

    public function save()
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'description' => $this->description,
            'sort_order' => $this->sort_order,
            'is_active' => $this->is_active,
            'gallery_category_id' => $this->category_id ?: null,
        ];

        if ($this->photo) {
            if ($this->editingId) {
                $gallery = Gallery::find($this->editingId);
                if ($gallery && $gallery->image) {
                    Storage::disk('public')->delete($gallery->image);
                }
            }
            $data['image'] = $this->photo->store('galleries', 'public');
        }

        if ($this->editingId) {
            Gallery::findOrFail($this->editingId)->update($data);
            session()->flash('success', 'Foto gallery berhasil diperbarui.');
        } else {
            Gallery::create($data);
            session()->flash('success', 'Foto gallery berhasil ditambahkan.');
        }

        $this->resetForm();
    }

    public function edit($id)
    {
        $gallery = Gallery::findOrFail($id);
        $this->editingId = $gallery->id;
        $this->title = $gallery->title;
        $this->description = $gallery->description ?? '';
        $this->sort_order = $gallery->sort_order;
        $this->is_active = $gallery->is_active;
        $this->category_id = $gallery->gallery_category_id ? (string) $gallery->gallery_category_id : '';
        $this->photo = null;
        $this->showForm = true;
    }

    public function delete($id)
    {
        $gallery = Gallery::findOrFail($id);
        if ($gallery->image) {
            Storage::disk('public')->delete($gallery->image);
        }
        $gallery->delete();
        session()->flash('success', 'Foto gallery berhasil dihapus.');
    }

    public function resetForm()
    {
        $this->reset(['title', 'description', 'photo', 'sort_order', 'is_active', 'category_id', 'showForm', 'editingId']);
        $this->is_active = true;
        $this->sort_order = 0;
    }

    // ── Category CRUD ──
    public function saveCategory()
    {
        $this->validate([
            'catName' => 'required|string|max:100',
            'catColor' => 'required|string|max:30',
        ]);

        if ($this->editingCatId) {
            GalleryCategory::findOrFail($this->editingCatId)->update([
                'name' => $this->catName,
                'color' => $this->catColor,
            ]);
            session()->flash('success', 'Kategori berhasil diperbarui.');
        } else {
            GalleryCategory::create([
                'name' => $this->catName,
                'color' => $this->catColor,
            ]);
            session()->flash('success', 'Kategori berhasil ditambahkan.');
        }

        $this->resetCatForm();
    }

    public function editCategory($id)
    {
        $cat = GalleryCategory::findOrFail($id);
        $this->editingCatId = $cat->id;
        $this->catName = $cat->name;
        $this->catColor = $cat->color;
        $this->showCatForm = true;
    }

    public function deleteCategory($id)
    {
        GalleryCategory::findOrFail($id)->delete();
        session()->flash('success', 'Kategori berhasil dihapus.');
    }

    public function resetCatForm()
    {
        $this->reset(['catName', 'catColor', 'showCatForm', 'editingCatId']);
        $this->catColor = 'green';
    }

    public function render()
    {
        $galleries = Gallery::with('category')
            ->when($this->filterCategory, fn($q) => $q->where('gallery_category_id', $this->filterCategory))
            ->ordered()
            ->paginate(12);

        return view('livewire.admin.gallery-management', [
            'galleries' => $galleries,
            'categories' => GalleryCategory::ordered()->get(),
        ]);
    }
}
