<div>
    <x-slot name="header">Keuangan & Kas</x-slot>
    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="bg-linear-to-br from-green-500 to-green-700 rounded-2xl p-5 text-white shadow-lg shadow-green-500/20">
            <p class="text-green-100 text-sm">Saldo Kas</p>
            <p class="text-2xl font-bold mt-1">Rp {{ number_format($balance, 0, ',', '.') }}</p>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
            <p class="text-gray-500 text-sm">Total Pemasukan</p>
            <p class="text-2xl font-bold text-emerald-600 mt-1">Rp {{ number_format($totalIncome, 0, ',', '.') }}</p>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
            <p class="text-gray-500 text-sm">Total Pengeluaran</p>
            <p class="text-2xl font-bold text-red-600 mt-1">Rp {{ number_format($totalExpense, 0, ',', '.') }}</p>
        </div>
    </div>

    {{-- Toolbar --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 mb-6">
        <div class="flex flex-col sm:flex-row gap-3 items-start sm:items-center justify-between">
            <div class="flex flex-wrap gap-2">
                <button wire:click="$set('showForm', true)" class="px-4 py-2 bg-green-600 text-white rounded-xl text-sm font-medium hover:bg-green-700 transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                    Tambah Transaksi
                </button>
                <a href="{{ route('finance.report') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-xl text-sm font-medium hover:bg-gray-200 transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Cetak Laporan PDF
                </a>
            </div>
            <div class="flex gap-2 w-full sm:w-auto">
                <select wire:model.live="filterType" class="px-3 py-2 border border-gray-200 rounded-xl text-sm focus:ring-green-500 focus:border-green-500">
                    <option value="">Semua Tipe</option>
                    <option value="income">Pemasukan</option>
                    <option value="expense">Pengeluaran</option>
                </select>
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari transaksi..." class="flex-1 px-3 py-2 border border-gray-200 rounded-xl text-sm focus:ring-green-500 focus:border-green-500">
            </div>
        </div>
    </div>

    {{-- Form Modal --}}
    @if($showForm)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4" x-transition>
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="font-semibold text-gray-800">{{ $editingId ? 'Edit Transaksi' : 'Tambah Transaksi' }}</h3>
                <button wire:click="resetForm" class="text-gray-400 hover:text-gray-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
            </div>
            <form wire:submit="save" class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                    <select wire:model="category_id" class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-green-500 focus:border-green-500">
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }} ({{ $cat->type === 'income' ? 'Masuk' : 'Keluar' }})</option>
                        @endforeach
                    </select>
                    @error('category_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah (Rp)</label>
                    <input wire:model="amount" type="number" placeholder="100000" class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-green-500 focus:border-green-500">
                    @error('amount') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                    <input wire:model="date" type="date" class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-green-500 focus:border-green-500">
                    @error('date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                    <textarea wire:model="description" rows="2" placeholder="Keterangan transaksi" class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-green-500 focus:border-green-500"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Bukti (Foto Struk)</label>
                    <input wire:model="evidence_file" type="file" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                    @error('evidence_file') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    @if($evidence_file)
                    <img src="{{ $evidence_file->temporaryUrl() }}" class="mt-2 w-32 h-32 object-cover rounded-xl border">
                    @endif
                </div>
                <div class="flex gap-3 pt-2">
                    <button type="button" wire:click="resetForm" class="flex-1 py-2.5 border border-gray-200 rounded-xl text-sm text-gray-600 hover:bg-gray-50 transition">Batal</button>
                    <button type="submit" class="flex-1 py-2.5 bg-green-600 text-white rounded-xl text-sm font-medium hover:bg-green-700 transition" wire:loading.attr="disabled">
                        <span wire:loading.remove>{{ $editingId ? 'Perbarui' : 'Simpan' }}</span>
                        <span wire:loading>Menyimpan...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    {{-- Transaction Table --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-gray-600">
                    <tr>
                        <th class="px-6 py-3 text-left font-medium">Tanggal</th>
                        <th class="px-6 py-3 text-left font-medium">Kategori</th>
                        <th class="px-6 py-3 text-left font-medium">Keterangan</th>
                        <th class="px-6 py-3 text-right font-medium">Jumlah</th>
                        <th class="px-6 py-3 text-left font-medium">Pencatat</th>
                        <th class="px-6 py-3 text-center font-medium">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($transactions as $trx)
                    <tr class="hover:bg-gray-50/50 transition">
                        <td class="px-6 py-3 text-gray-600">{{ $trx->date->format('d/m/Y') }}</td>
                        <td class="px-6 py-3">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $trx->category->type === 'income' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                                {{ $trx->category->name }}
                            </span>
                        </td>
                        <td class="px-6 py-3 text-gray-600 max-w-xs truncate">{{ $trx->description ?? '-' }}</td>
                        <td class="px-6 py-3 text-right font-semibold {{ $trx->category->type === 'income' ? 'text-emerald-600' : 'text-red-600' }}">
                            Rp {{ number_format($trx->amount, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-3 text-gray-500">{{ $trx->user->name }}</td>
                        <td class="px-6 py-3 text-center">
                            <div class="flex items-center justify-center gap-1">
                                @if($trx->evidence_file)
                                <a href="{{ asset('storage/' . $trx->evidence_file) }}" target="_blank" class="p-1.5 rounded-lg text-blue-500 hover:bg-blue-50 transition" title="Lihat Bukti">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                                @endif
                                <button wire:click="edit({{ $trx->id }})" class="p-1.5 rounded-lg text-amber-500 hover:bg-amber-50 transition" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </button>
                                <button wire:click="delete({{ $trx->id }})" wire:confirm="Yakin ingin menghapus transaksi ini?" class="p-1.5 rounded-lg text-red-500 hover:bg-red-50 transition" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="px-6 py-12 text-center text-gray-400">Belum ada data transaksi.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-3 border-t border-gray-100">
            {{ $transactions->links() }}
        </div>
    </div>
</div>
