<div>
    <x-slot name="header">Kelola Gallery</x-slot>
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-6">
        <p class="text-gray-500 text-sm">Kelola foto gallery dan kategori yang ditampilkan di landing page</p>
        <div class="flex gap-2">
            <button wire:click="$set('showCatForm', true)" class="px-4 py-2 border border-gray-200 text-gray-700 rounded-xl text-sm font-medium hover:bg-gray-50 transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                Kategori
            </button>
            <button wire:click="$set('showForm', true)" class="px-4 py-2 bg-green-600 text-white rounded-xl text-sm font-medium hover:bg-green-700 transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                Tambah Foto
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-transition>{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm">{{ session('error') }}</div>
    @endif

    {{-- Category Filter Tabs --}}
    @if($categories->count() > 0)
    <div class="mb-6 flex flex-wrap gap-2">
        <button wire:click="$set('filterCategory', '')" class="px-3.5 py-1.5 rounded-full text-xs font-medium transition {{ $filterCategory === '' ? 'bg-green-600 text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
            Semua
        </button>
        @foreach($categories as $cat)
        <button wire:click="$set('filterCategory', '{{ $cat->id }}')" class="px-3.5 py-1.5 rounded-full text-xs font-medium transition {{ (string)$filterCategory === (string)$cat->id ? 'bg-green-600 text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
            {{ $cat->name }}
        </button>
        @endforeach
    </div>
    @endif

    {{-- Category Form Modal --}}
    @if($showCatForm)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md max-h-[90vh] overflow-y-auto">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="font-semibold text-gray-800">{{ $editingCatId ? 'Edit Kategori' : 'Kelola Kategori' }}</h3>
                <button wire:click="resetCatForm" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="p-6">
                {{-- Add/Edit Category Form --}}
                <form wire:submit="saveCategory" class="flex gap-2 mb-5">
                    <input wire:model="catName" type="text" placeholder="Nama kategori" class="flex-1 px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-green-500 focus:border-green-500">
                    <select wire:model="catColor" class="px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-green-500 focus:border-green-500">
                        <option value="green">🟢 Hijau</option>
                        <option value="blue">🔵 Biru</option>
                        <option value="amber">🟡 Kuning</option>
                        <option value="rose">🔴 Merah</option>
                        <option value="purple">🟣 Ungu</option>
                        <option value="cyan">🔹 Cyan</option>
                        <option value="indigo">🔮 Indigo</option>
                    </select>
                    <button type="submit" class="px-4 py-2.5 bg-green-600 text-white rounded-xl text-sm font-medium hover:bg-green-700 whitespace-nowrap">
                        {{ $editingCatId ? 'Update' : 'Tambah' }}
                    </button>
                </form>
                @error('catName') <p class="text-red-500 text-xs -mt-3 mb-3">{{ $message }}</p> @enderror

                {{-- Category List --}}
                <div class="space-y-2">
                    @forelse($categories as $cat)
                    <div class="flex items-center justify-between px-4 py-3 bg-gray-50 rounded-xl group">
                        <div class="flex items-center gap-2.5">
                            <span class="w-3 h-3 rounded-full bg-{{ $cat->color }}-500"></span>
                            <span class="text-sm font-medium text-gray-700">{{ $cat->name }}</span>
                            <span class="text-xs text-gray-400">({{ $cat->galleries_count ?? $cat->galleries->count() }} foto)</span>
                        </div>
                        <div class="flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                            <button wire:click="editCategory({{ $cat->id }})" class="p-1 text-amber-500 hover:bg-amber-50 rounded-lg transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </button>
                            <button wire:click="deleteCategory({{ $cat->id }})" wire:confirm="Yakin hapus kategori '{{ $cat->name }}'? Foto di kategori ini tidak akan dihapus." class="p-1 text-red-500 hover:bg-red-50 rounded-lg transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>
                    </div>
                    @empty
                    <p class="text-gray-400 text-sm text-center py-4">Belum ada kategori.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Photo Form Modal --}}
    @if($showForm)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between sticky top-0 bg-white rounded-t-2xl">
                <h3 class="font-semibold text-gray-800">{{ $editingId ? 'Edit Foto' : 'Tambah Foto Baru' }}</h3>
                <button wire:click="resetForm" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <form wire:submit="save" class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Judul Foto</label>
                    <input wire:model="title" type="text" placeholder="Contoh: Gotong Royong 2026" class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-green-500 focus:border-green-500">
                    @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                    <select wire:model="category_id" class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-green-500 focus:border-green-500">
                        <option value="">— Tanpa Kategori —</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi <span class="text-gray-400">(opsional)</span></label>
                    <textarea wire:model="description" rows="2" placeholder="Keterangan singkat tentang foto" class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-green-500 focus:border-green-500"></textarea>
                    @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Foto {{ $editingId ? '(kosongkan jika tidak ingin mengubah)' : '' }}
                    </label>
                    <div class="mt-1">
                        <label class="flex flex-col items-center justify-center w-full h-40 border-2 border-dashed border-gray-300 rounded-xl cursor-pointer hover:border-green-400 hover:bg-green-50/30 transition-all duration-200">
                            @if($photo)
                                <img src="{{ $photo->temporaryUrl() }}" class="h-full w-full object-cover rounded-xl" alt="Preview">
                            @else
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-10 h-10 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <p class="text-xs text-gray-500">Klik untuk pilih foto</p>
                                    <p class="text-[10px] text-gray-400 mt-1">JPG, PNG, WEBP (maks. 2MB)</p>
                                </div>
                            @endif
                            <input wire:model="photo" type="file" accept="image/*" class="hidden">
                        </label>
                        <div wire:loading wire:target="photo" class="text-sm text-green-600 mt-2 flex items-center gap-1">
                            <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                            Mengunggah...
                        </div>
                    </div>
                    @error('photo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Urutan</label>
                        <input wire:model="sort_order" type="number" min="0" class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-green-500 focus:border-green-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select wire:model="is_active" class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-green-500 focus:border-green-500">
                            <option value="1">Aktif</option>
                            <option value="0">Nonaktif</option>
                        </select>
                    </div>
                </div>
                <div class="flex gap-3 pt-2">
                    <button type="button" wire:click="resetForm" class="flex-1 py-2.5 border border-gray-200 rounded-xl text-sm text-gray-600 hover:bg-gray-50">Batal</button>
                    <button type="submit" class="flex-1 py-2.5 bg-green-600 text-white rounded-xl text-sm font-medium hover:bg-green-700" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="save">Simpan</span>
                        <span wire:loading wire:target="save">Menyimpan...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    {{-- Gallery Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
        @forelse($galleries as $gallery)
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden group hover:shadow-md transition">
            <div class="relative aspect-square overflow-hidden">
                <img src="{{ asset('storage/' . $gallery->image) }}" alt="{{ $gallery->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                @if(!$gallery->is_active)
                <div class="absolute top-2 left-2">
                    <span class="px-2 py-0.5 bg-gray-800/70 text-white text-[10px] font-medium rounded-full">Nonaktif</span>
                </div>
                @endif
                @if($gallery->category)
                <div class="absolute bottom-2 left-2">
                    <span class="px-2 py-0.5 bg-{{ $gallery->category->color }}-500/80 text-white text-[10px] font-medium rounded-full backdrop-blur-sm">{{ $gallery->category->name }}</span>
                </div>
                @endif
                <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                    <div class="flex gap-1">
                        <button wire:click="edit({{ $gallery->id }})" class="p-1.5 bg-white/90 text-amber-600 rounded-lg hover:bg-white transition shadow-sm" title="Edit">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </button>
                        <button wire:click="delete({{ $gallery->id }})" wire:confirm="Yakin ingin menghapus foto '{{ $gallery->title }}'?" class="p-1.5 bg-white/90 text-red-600 rounded-lg hover:bg-white transition shadow-sm" title="Hapus">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </div>
                </div>
            </div>
            <div class="p-3">
                <h4 class="font-semibold text-gray-800 text-sm truncate">{{ $gallery->title }}</h4>
                @if($gallery->description)
                <p class="text-gray-400 text-xs truncate mt-0.5">{{ $gallery->description }}</p>
                @endif
            </div>
        </div>
        @empty
        <div class="col-span-full bg-white rounded-2xl border border-gray-100 p-12 text-center">
            <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            <p class="text-gray-400">{{ $filterCategory ? 'Tidak ada foto di kategori ini.' : 'Belum ada foto di gallery.' }}</p>
            <p class="text-gray-400 text-sm mt-1">Klik "Tambah Foto" untuk menambahkan.</p>
        </div>
        @endforelse
    </div>
    <div class="mt-4">{{ $galleries->links() }}</div>
</div>
