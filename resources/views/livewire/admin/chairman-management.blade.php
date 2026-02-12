<div>
    <x-slot name="header">Kelola Ketua Karang Taruna</x-slot>
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-6">
        <p class="text-gray-500 text-sm">Data ketua Karang Taruna yang ditampilkan di landing page</p>
        <button wire:click="$set('showForm', true)" class="px-4 py-2 bg-green-600 text-white rounded-xl text-sm font-medium hover:bg-green-700 transition flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            Tambah Ketua
        </button>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-transition>{{ session('success') }}</div>
    @endif

    {{-- Form Modal --}}
    @if($showForm)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between sticky top-0 bg-white rounded-t-2xl z-10">
                <h3 class="font-semibold text-gray-800">{{ $editingId ? 'Edit Data Ketua' : 'Tambah Ketua Baru' }}</h3>
                <button wire:click="resetForm" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <form wire:submit="save" class="p-6 space-y-4">
                {{-- Photo --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Foto {{ $editingId ? '(kosongkan jika tidak diubah)' : '' }}</label>
                    <label class="flex flex-col items-center justify-center w-full h-40 border-2 border-dashed border-gray-300 rounded-xl cursor-pointer hover:border-green-400 hover:bg-green-50/30 transition-all duration-200">
                        @if($photo)
                            <img src="{{ $photo->temporaryUrl() }}" class="h-full w-full object-cover rounded-xl" alt="Preview">
                        @else
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-10 h-10 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                <p class="text-xs text-gray-500">Klik untuk pilih foto</p>
                                <p class="text-[10px] text-gray-400 mt-1">JPG, PNG (maks. 2MB)</p>
                            </div>
                        @endif
                        <input wire:model="photo" type="file" accept="image/*" class="hidden">
                    </label>
                    <div wire:loading wire:target="photo" class="text-sm text-green-600 mt-2 flex items-center gap-1">
                        <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                        Mengunggah...
                    </div>
                    @error('photo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Name --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                    <input wire:model="name" type="text" placeholder="Masukkan nama lengkap" class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-green-500 focus:border-green-500">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Birth Place & Date --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tempat Lahir</label>
                        <input wire:model="birth_place" type="text" placeholder="Contoh: Jakarta" class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-green-500 focus:border-green-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir</label>
                        <input wire:model="birth_date" type="date" class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-green-500 focus:border-green-500">
                    </div>
                </div>

                {{-- Period --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Periode Jabatan</label>
                    <input wire:model="period" type="text" placeholder="Contoh: 2024 - 2026" class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-green-500 focus:border-green-500">
                    @error('period') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Achievements --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Prestasi yang Diraih</label>
                    <div class="space-y-2">
                        @foreach($achievements as $index => $achievement)
                        <div class="flex gap-2">
                            <input wire:model="achievements.{{ $index }}" type="text" placeholder="Contoh: Juara 1 Lomba Desa" class="flex-1 px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-green-500 focus:border-green-500">
                            @if(count($achievements) > 1)
                            <button type="button" wire:click="removeAchievement({{ $index }})" class="p-2.5 text-red-400 hover:text-red-600 hover:bg-red-50 rounded-xl transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                            @endif
                        </div>
                        @endforeach
                    </div>
                    <button type="button" wire:click="addAchievement" class="mt-2 text-sm text-green-600 hover:text-green-700 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                        Tambah Prestasi
                    </button>
                </div>

                {{-- Sort & Status --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Urutan</label>
                        <input wire:model="sort_order" type="number" min="0" class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-green-500 focus:border-green-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select wire:model="is_active" class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-green-500 focus:border-green-500">
                            <option value="1">Aktif (Menjabat)</option>
                            <option value="0">Nonaktif</option>
                        </select>
                    </div>
                </div>

                {{-- Actions --}}
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

    {{-- Chairman Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($chairmans as $chairman)
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden group hover:shadow-md transition">
            <div class="relative">
                @if($chairman->photo)
                <div class="aspect-[4/3] overflow-hidden">
                    <img src="{{ asset('storage/' . $chairman->photo) }}" alt="{{ $chairman->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                </div>
                @else
                <div class="aspect-[4/3] bg-gradient-to-br from-green-100 to-green-200 flex items-center justify-center">
                    <svg class="w-16 h-16 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
                @endif
                <div class="absolute top-2 right-2 flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                    <button wire:click="edit({{ $chairman->id }})" class="p-1.5 bg-white/90 text-amber-600 rounded-lg hover:bg-white transition shadow-sm" title="Edit">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </button>
                    <button wire:click="delete({{ $chairman->id }})" wire:confirm="Yakin hapus data '{{ $chairman->name }}'?" class="p-1.5 bg-white/90 text-red-600 rounded-lg hover:bg-white transition shadow-sm" title="Hapus">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </button>
                </div>
                @if($chairman->is_active)
                <div class="absolute top-2 left-2">
                    <span class="px-2 py-0.5 bg-green-500/80 text-white text-[10px] font-medium rounded-full backdrop-blur-sm">Menjabat</span>
                </div>
                @endif
            </div>
            <div class="p-4">
                <h4 class="font-bold text-gray-800 text-base">{{ $chairman->name }}</h4>
                <p class="text-green-600 text-sm font-medium">Periode {{ $chairman->period }}</p>
                @if($chairman->formatted_birth)
                <p class="text-gray-400 text-xs mt-1">{{ $chairman->formatted_birth }}</p>
                @endif
                @if($chairman->achievements && count($chairman->achievements) > 0)
                <div class="mt-3 pt-3 border-t border-gray-100">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Prestasi</p>
                    <ul class="space-y-1">
                        @foreach(array_slice($chairman->achievements, 0, 3) as $a)
                        <li class="text-xs text-gray-500 flex items-start gap-1.5">
                            <svg class="w-3 h-3 text-green-500 mt-0.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            {{ $a }}
                        </li>
                        @endforeach
                        @if(count($chairman->achievements) > 3)
                        <li class="text-xs text-gray-400">+{{ count($chairman->achievements) - 3 }} lainnya</li>
                        @endif
                    </ul>
                </div>
                @endif
            </div>
        </div>
        @empty
        <div class="col-span-full bg-white rounded-2xl border border-gray-100 p-12 text-center">
            <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            <p class="text-gray-400">Belum ada data ketua.</p>
            <p class="text-gray-400 text-sm mt-1">Klik "Tambah Ketua" untuk menambahkan.</p>
        </div>
        @endforelse
    </div>
    <div class="mt-4">{{ $chairmans->links() }}</div>
</div>
