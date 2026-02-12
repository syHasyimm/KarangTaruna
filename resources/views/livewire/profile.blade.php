<div>
    <x-slot name="header">Profil Saya</x-slot>
    <div class="max-w-4xl mx-auto space-y-6">
        {{-- Header --}}
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Pengaturan Profil</h1>
            <p class="text-gray-500 text-sm">Kelola informasi akun dan keamanan Anda</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Profile Information --}}
            <div class="md:col-span-2 space-y-6">
                {{-- Basic Info Card --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Informasi Dasar</h2>
                    
                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            {{ session('success') }}
                        </div>
                    @endif

                    <form wire:submit="updateProfile" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                            <input wire:model="name" type="text" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-green-500 focus:border-green-500">
                            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input wire:model="email" type="email" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-green-500 focus:border-green-500">
                            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="pt-2">
                            <button type="submit" class="px-6 py-2.5 bg-green-600 text-white rounded-xl text-sm font-medium hover:bg-green-700 transition shadow-lg shadow-green-500/20">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Password Update --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Ganti Password</h2>

                    @if(session('password_success'))
                        <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            {{ session('password_success') }}
                        </div>
                    @endif

                    <form wire:submit="updatePassword" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Password Saat Ini</label>
                            <input wire:model="current_password" type="password" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-green-500 focus:border-green-500">
                            @error('current_password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                            <input wire:model="password" type="password" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-green-500 focus:border-green-500">
                            @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
                            <input wire:model="password_confirmation" type="password" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-green-500 focus:border-green-500">
                        </div>
                        <div class="pt-2">
                            <button type="submit" class="px-6 py-2.5 bg-gray-800 text-white rounded-xl text-sm font-medium hover:bg-gray-900 transition shadow-lg shadow-gray-500/20">
                                Update Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Sidebar / Info --}}
            <div class="space-y-6">
                <div class="bg-gradient-to-br from-green-500 to-green-700 rounded-2xl p-6 text-white shadow-lg shadow-green-500/20 text-center">
                    <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center text-3xl font-bold mx-auto mb-4 backdrop-blur-sm">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <h3 class="font-bold text-lg">{{ auth()->user()->name }}</h3>
                    <p class="text-green-100 text-sm mb-4">{{ auth()->user()->email }}</p>
                    <div class="inline-flex items-center px-3 py-1 rounded-full bg-white/20 text-xs font-medium backdrop-blur-sm border border-white/20">
                        {{ ucfirst(auth()->user()->getRoleNames()->first() ?? 'Warga') }}
                    </div>
                    @if(auth()->user()->village_id)
                    <div class="mt-4 pt-4 border-t border-white/10 text-sm text-green-100">
                        <p class="text-xs uppercase tracking-widest opacity-70 mb-1">ID Desa</p>
                        <p class="font-mono">{{ auth()->user()->village_id }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
