<div>
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-6">
        <div>
            <p class="text-gray-500 text-sm">Daftar event voting yang tersedia untuk warga</p>
        </div>
        @role('admin')
        <button wire:click="$set('showForm', true)" class="px-4 py-2 bg-green-600 text-white rounded-xl text-sm font-medium hover:bg-green-700 transition flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            Buat Voting Baru
        </button>
        @endrole
    </div>

    {{-- Admin Form Modal --}}
    @if($showForm)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="font-semibold text-gray-800">{{ $editingId ? 'Edit Voting' : 'Buat Voting Baru' }}</h3>
                <button wire:click="resetForm" class="text-gray-400 hover:text-gray-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
            </div>
            <form wire:submit="save" class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Judul Voting</label>
                    <input wire:model="title" type="text" placeholder="Contoh: Pemilihan Ketua 2026" class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-green-500 focus:border-green-500">
                    @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <textarea wire:model="description" rows="3" placeholder="Jelaskan tujuan voting ini" class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-green-500 focus:border-green-500"></textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
                        <input wire:model="year" type="number" class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-green-500 focus:border-green-500">
                        @error('year') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select wire:model="status" class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-green-500 focus:border-green-500">
                            <option value="draft">Draft</option>
                            <option value="open">Dibuka</option>
                            <option value="closed">Ditutup</option>
                        </select>
                    </div>
                </div>
                <div class="flex gap-3 pt-2">
                    <button type="button" wire:click="resetForm" class="flex-1 py-2.5 border border-gray-200 rounded-xl text-sm text-gray-600 hover:bg-gray-50">Batal</button>
                    <button type="submit" class="flex-1 py-2.5 bg-green-600 text-white rounded-xl text-sm font-medium hover:bg-green-700">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    @endif

    {{-- Voting Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($events as $event)
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden hover:shadow-md transition group">
            <div class="p-6">
                <div class="flex items-center justify-between mb-3">
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
                        {{ $event->status === 'open' ? 'bg-green-100 text-green-700' : ($event->status === 'draft' ? 'bg-yellow-100 text-yellow-700' : 'bg-gray-100 text-gray-600') }}">
                        {{ $event->status === 'open' ? 'Dibuka' : ($event->status === 'draft' ? 'Draft' : 'Ditutup') }}
                    </span>
                    <span class="text-xs text-gray-400">{{ $event->year }}</span>
                </div>
                <h3 class="font-semibold text-gray-800 text-lg mb-2 group-hover:text-green-700 transition">{{ $event->title }}</h3>
                <p class="text-gray-500 text-sm line-clamp-2 mb-4">{{ $event->description ?? 'Tidak ada deskripsi.' }}</p>
                <div class="flex items-center justify-between">
                    <p class="text-xs text-gray-400">{{ $event->votes_count }} suara masuk</p>
                    <div class="flex gap-1">
                        @if($event->status === 'open')
                        <a href="{{ route('voting.show', $event) }}" class="px-3 py-1.5 bg-green-600 text-white rounded-lg text-xs font-medium hover:bg-green-700 transition">Vote Sekarang</a>
                        @endif
                        @role('admin')
                        <button wire:click="edit({{ $event->id }})" class="p-1.5 text-amber-500 hover:bg-amber-50 rounded-lg transition"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></button>
                        <button wire:click="delete({{ $event->id }})" wire:confirm="Yakin ingin menghapus voting ini?" class="p-1.5 text-red-500 hover:bg-red-50 rounded-lg transition"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>
                        @endrole
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full bg-white rounded-2xl border border-gray-100 p-12 text-center">
            <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
            <p class="text-gray-400">Belum ada event voting.</p>
        </div>
        @endforelse
    </div>
</div>
