<div>
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-6">
        <p class="text-gray-500 text-sm">Informasi dan kabar terbaru dari desa</p>
        @role('admin')
        <button wire:click="$set('showForm', true)" class="px-4 py-2 bg-green-600 text-white rounded-xl text-sm font-medium hover:bg-green-700 transition flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            Tulis Berita
        </button>
        @endrole
    </div>

    {{-- Admin Form Modal --}}
    @if($showForm)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="font-semibold text-gray-800">{{ $editingId ? 'Edit Berita' : 'Tulis Berita Baru' }}</h3>
                <button wire:click="resetForm" class="text-gray-400 hover:text-gray-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
            </div>
            <form wire:submit="save" class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Judul Berita</label>
                    <input wire:model="title" type="text" placeholder="Judul berita..." class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-green-500 focus:border-green-500">
                    @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Thumbnail</label>
                    <input wire:model="thumbnail" type="file" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                    @error('thumbnail') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Isi Berita</label>
                    <textarea wire:model="content" rows="8" placeholder="Tulis isi berita di sini..." class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-green-500 focus:border-green-500"></textarea>
                    @error('content') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="flex gap-3 pt-2">
                    <button type="button" wire:click="resetForm" class="flex-1 py-2.5 border border-gray-200 rounded-xl text-sm text-gray-600 hover:bg-gray-50">Batal</button>
                    <button type="submit" class="flex-1 py-2.5 bg-green-600 text-white rounded-xl text-sm font-medium hover:bg-green-700">Publikasikan</button>
                </div>
            </form>
        </div>
    </div>
    @endif

    {{-- News Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($newsList as $news)
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden hover:shadow-md transition group">
            @if($news->thumbnail)
            <div class="h-48 overflow-hidden">
                <img src="{{ asset('storage/' . $news->thumbnail) }}" alt="{{ $news->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
            </div>
            @else
            <div class="h-48 bg-linear-to-br from-green-100 to-green-200 flex items-center justify-center">
                <svg class="w-16 h-16 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
            </div>
            @endif
            <div class="p-5">
                <p class="text-xs text-gray-400 mb-2">{{ $news->created_at->diffForHumans() }}</p>
                <h3 class="font-semibold text-gray-800 mb-2 line-clamp-2 group-hover:text-green-700 transition">{{ $news->title }}</h3>
                <p class="text-gray-500 text-sm line-clamp-3">{{ Str::limit(strip_tags($news->content), 120) }}</p>
                <div class="flex items-center justify-between mt-4">
                    <a href="{{ route('news.show', $news) }}" class="text-green-600 text-sm font-medium hover:underline">Baca Selengkapnya</a>
                    @role('admin')
                    <div class="flex gap-1">
                        <button wire:click="edit({{ $news->id }})" class="p-1.5 text-amber-500 hover:bg-amber-50 rounded-lg transition"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></button>
                        <button wire:click="delete({{ $news->id }})" wire:confirm="Yakin hapus berita ini?" class="p-1.5 text-red-500 hover:bg-red-50 rounded-lg transition"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>
                    </div>
                    @endrole
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full bg-white rounded-2xl border border-gray-100 p-12 text-center">
            <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
            <p class="text-gray-400">Belum ada berita.</p>
        </div>
        @endforelse
    </div>

    <div class="mt-6">{{ $newsList->links() }}</div>
</div>
