<div>
    <x-slot name="header">Kelola Pengguna</x-slot>
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-6">
        <p class="text-gray-500 text-sm">Kelola pengguna dan atur hak akses mereka</p>
        <button wire:click="$set('showForm', true)" class="px-4 py-2 bg-green-600 text-white rounded-xl text-sm font-medium hover:bg-green-700 transition flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
            Tambah Pengguna
        </button>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm">{{ session('error') }}</div>
    @endif

    {{-- Search --}}
    <div class="mb-4">
        <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari nama atau email..."
               class="w-full sm:w-80 px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-green-500 focus:border-green-500">
    </div>

    {{-- Form Modal --}}
    @if($showForm)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="font-semibold text-gray-800">{{ $editingId ? 'Edit Pengguna' : 'Tambah Pengguna Baru' }}</h3>
                <button wire:click="resetForm" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <form wire:submit="save" class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                    <input wire:model="name" type="text" placeholder="Nama lengkap" class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-green-500 focus:border-green-500">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input wire:model="email" type="email" placeholder="email@contoh.com" class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-green-500 focus:border-green-500">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password {{ $editingId ? '(kosongkan jika tidak ingin mengubah)' : '' }}</label>
                    <input wire:model="password" type="password" placeholder="{{ $editingId ? 'Kosongkan jika tidak diubah' : 'Minimal 8 karakter' }}" class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-green-500 focus:border-green-500">
                    @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">ID Desa</label>
                    <input wire:model="village_id" type="text" placeholder="Contoh: DS001" class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-green-500 focus:border-green-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Role / Hak Akses</label>
                    <select wire:model="selectedRole" class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-green-500 focus:border-green-500">
                        <option value="admin">Admin</option>
                        <option value="bendahara">Bendahara</option>
                        <option value="warga">Warga</option>
                    </select>
                    @error('selectedRole') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="flex gap-3 pt-2">
                    <button type="button" wire:click="resetForm" class="flex-1 py-2.5 border border-gray-200 rounded-xl text-sm text-gray-600 hover:bg-gray-50">Batal</button>
                    <button type="submit" class="flex-1 py-2.5 bg-green-600 text-white rounded-xl text-sm font-medium hover:bg-green-700">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    @endif

    {{-- Users Table --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="text-left px-6 py-3 font-medium text-gray-500">Nama</th>
                        <th class="text-left px-6 py-3 font-medium text-gray-500">Email</th>
                        <th class="text-left px-6 py-3 font-medium text-gray-500">Role</th>
                        <th class="text-left px-6 py-3 font-medium text-gray-500">ID Desa</th>
                        <th class="text-right px-6 py-3 font-medium text-gray-500">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($users as $user)
                    <tr class="hover:bg-gray-50/50">
                        <td class="px-6 py-3 font-medium text-gray-800">{{ $user->name }}</td>
                        <td class="px-6 py-3 text-gray-500">{{ $user->email }}</td>
                        <td class="px-6 py-3">
                            @php $role = $user->roles->first()?->name ?? '-'; @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $role === 'admin' ? 'bg-purple-100 text-purple-700' : ($role === 'bendahara' ? 'bg-blue-100 text-blue-700' : 'bg-green-100 text-green-700') }}">
                                {{ ucfirst($role) }}
                            </span>
                        </td>
                        <td class="px-6 py-3 text-gray-500">{{ $user->village_id ?? '-' }}</td>
                        <td class="px-6 py-3 text-right">
                            <div class="flex justify-end gap-1">
                                <button wire:click="edit({{ $user->id }})" class="p-1.5 text-amber-500 hover:bg-amber-50 rounded-lg transition" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </button>
                                @if($user->id !== auth()->id())
                                <button wire:click="delete({{ $user->id }})" wire:confirm="Yakin hapus pengguna {{ $user->name }}?" class="p-1.5 text-red-500 hover:bg-red-50 rounded-lg transition" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-400">Tidak ada pengguna ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4">{{ $users->links() }}</div>
</div>
