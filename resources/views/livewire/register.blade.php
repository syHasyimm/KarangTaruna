<div class="w-full max-w-md">
    {{-- Logo --}}
    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-green-500 to-green-700 rounded-2xl shadow-lg shadow-green-200 mb-4">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
        </div>
        <h1 class="text-2xl font-bold text-gray-800">Daftar Akun Warga</h1>
        <p class="text-gray-500 text-sm mt-1">Bergabung untuk berpartisipasi dalam voting desa</p>
    </div>

    {{-- Register Card --}}
    <div class="bg-white rounded-2xl shadow-xl shadow-gray-200/50 border border-gray-100 p-8">
        <form wire:submit="register" class="space-y-4">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">Nama Lengkap</label>
                <input wire:model="name" type="text" id="name" placeholder="Masukkan nama lengkap"
                       class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all duration-200 text-sm placeholder:text-gray-400 outline-none">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                <input wire:model="email" type="email" id="email" placeholder="contoh@email.com"
                       class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all duration-200 text-sm placeholder:text-gray-400 outline-none">
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="village_id" class="block text-sm font-medium text-gray-700 mb-1.5">ID Desa <span class="text-gray-400 font-normal">(opsional)</span></label>
                <input wire:model="village_id" type="text" id="village_id" placeholder="Contoh: DS001"
                       class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all duration-200 text-sm placeholder:text-gray-400 outline-none">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
                <input wire:model="password" type="password" id="password" placeholder="Minimal 8 karakter"
                       class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all duration-200 text-sm placeholder:text-gray-400 outline-none">
                @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1.5">Konfirmasi Password</label>
                <input wire:model="password_confirmation" type="password" id="password_confirmation" placeholder="Ulangi password"
                       class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all duration-200 text-sm placeholder:text-gray-400 outline-none">
            </div>

            <button type="submit"
                    class="w-full py-3 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-xl font-semibold text-sm hover:from-green-700 hover:to-green-800 focus:ring-4 focus:ring-green-500/30 transition-all duration-200 shadow-lg shadow-green-500/25"
                    wire:loading.attr="disabled" wire:loading.class="opacity-70">
                <span wire:loading.remove>Daftar Sekarang</span>
                <span wire:loading class="flex items-center justify-center gap-2">
                    <svg class="animate-spin h-4 w-4" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                    Memproses...
                </span>
            </button>
        </form>

        <div class="mt-5 text-center">
            <p class="text-sm text-gray-500">Sudah punya akun? <a href="{{ route('login') }}" class="text-green-600 font-medium hover:underline">Masuk</a></p>
        </div>
    </div>

    <p class="text-center text-xs text-gray-400 mt-6">&copy; {{ date('Y') }} KarangTaruna. Semua hak dilindungi.</p>
</div>
