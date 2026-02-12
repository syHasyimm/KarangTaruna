<div class="w-full max-w-md">
    {{-- Logo Card --}}
    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-linear-to-br from-green-500 to-green-700 rounded-2xl shadow-lg shadow-green-200 mb-4">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
        </div>
        <h1 class="text-2xl font-bold text-gray-800">KarangTaruna</h1>
        <p class="text-gray-500 text-sm mt-1">Sistem Manajemen Desa</p>
    </div>

    {{-- Login Card --}}
    <div class="bg-white rounded-2xl shadow-xl shadow-gray-200/50 border border-gray-100 p-8">
        <h2 class="text-xl font-semibold text-gray-800 mb-1">Selamat Datang</h2>
        <p class="text-gray-500 text-sm mb-6">Masuk ke akun Anda untuk melanjutkan</p>

        <form wire:submit="login" class="space-y-5">
            {{-- Email --}}
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                <input wire:model="email" type="email" id="email" placeholder="contoh@email.com"
                       class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all duration-200 text-sm placeholder:text-gray-400 outline-none">
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Password --}}
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
                <input wire:model="password" type="password" id="password" placeholder="Masukkan password"
                       class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all duration-200 text-sm placeholder:text-gray-400 outline-none">
                @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Remember Me --}}
            <div class="flex items-center gap-2">
                <input wire:model="remember" type="checkbox" id="remember"
                       class="w-4 h-4 rounded border-gray-300 text-green-600 focus:ring-green-500">
                <label for="remember" class="text-sm text-gray-600">Ingat saya</label>
            </div>

            {{-- Submit --}}
            <button type="submit"
                    class="w-full py-3 bg-linear-to-r from-green-600 to-green-700 text-white rounded-xl font-semibold text-sm hover:from-green-700 hover:to-green-800 focus:ring-4 focus:ring-green-500/30 transition-all duration-200 shadow-lg shadow-green-500/25"
                    wire:loading.attr="disabled" wire:loading.class="opacity-70">
                <span wire:loading.remove>Masuk</span>
                <span wire:loading class="flex items-center justify-center gap-2">
                    <svg class="animate-spin h-4 w-4" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                    Memproses...
                </span>
            </button>
        </form>
    </div>

    <p class="text-center text-xs text-gray-400 mt-6">&copy; {{ date('Y') }} KarangTaruna. Semua hak dilindungi.</p>
</div>
