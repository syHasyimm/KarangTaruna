<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'KarangTaruna' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-inter bg-gray-50 min-h-screen">
    <div class="flex min-h-screen" x-data="{ sidebarOpen: false }">
        {{-- Mobile Overlay --}}
        <div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-black/50 z-40 lg:hidden" @click="sidebarOpen = false"></div>

        {{-- Sidebar --}}
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
               class="fixed inset-y-0 left-0 z-50 w-72 bg-linear-to-b from-green-700 via-green-800 to-green-900 text-white transform transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0 flex flex-col shadow-2xl">
            {{-- Logo --}}
            <div class="flex items-center gap-3 px-6 py-5 border-b border-green-600/50">
                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                    <svg class="w-6 h-6 text-green-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                </div>
                <div>
                    <h1 class="font-bold text-lg tracking-tight">KarangTaruna</h1>
                    <p class="text-green-300 text-xs">Sistem Manajemen Desa</p>
                </div>
                <button @click="sidebarOpen = false" class="ml-auto lg:hidden text-green-300 hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            {{-- User Info --}}
            <div class="px-6 py-4 border-b border-green-600/30">
                <a href="{{ route('profile') }}" class="flex items-center gap-3 group">
                    <div class="w-9 h-9 bg-green-500/40 rounded-full flex items-center justify-center text-sm font-semibold group-hover:bg-green-500/60 transition">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium truncate group-hover:text-green-200 transition">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-green-300 capitalize">{{ auth()->user()->getRoleNames()->first() ?? 'Warga' }} &bull; Edit Profil</p>
                    </div>
                </a>
            </div>

            {{-- Navigation --}}
            <nav class="flex-1 px-4 py-4 space-y-1 overflow-y-auto">
                <p class="text-green-400 text-[10px] uppercase tracking-widest font-semibold px-3 mb-2">Menu Utama</p>

                @hasanyrole('admin|bendahara')
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-white/15 text-white font-semibold shadow-lg shadow-green-900/20' : 'text-green-200 hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Dashboard
                </a>
                @endhasanyrole

                @hasanyrole('admin|bendahara')
                <p class="text-green-400 text-[10px] uppercase tracking-widest font-semibold px-3 mt-5 mb-2">Keuangan</p>

                <a href="{{ route('finance.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200 {{ request()->routeIs('finance.*') ? 'bg-white/15 text-white font-semibold shadow-lg shadow-green-900/20' : 'text-green-200 hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Transaksi
                </a>
                @endhasanyrole

                <p class="text-green-400 text-[10px] uppercase tracking-widest font-semibold px-3 mt-5 mb-2">Komunitas</p>

                <a href="{{ route('voting.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200 {{ request()->routeIs('voting.*') ? 'bg-white/15 text-white font-semibold shadow-lg shadow-green-900/20' : 'text-green-200 hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                    Voting
                </a>

                <a href="{{ route('news.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200 {{ request()->routeIs('news.*') ? 'bg-white/15 text-white font-semibold shadow-lg shadow-green-900/20' : 'text-green-200 hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                    Berita
                </a>

                @role('admin')
                <p class="text-green-400 text-[10px] uppercase tracking-widest font-semibold px-3 mt-5 mb-2">Administrasi</p>

                <a href="{{ route('admin.users') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200 {{ request()->routeIs('admin.users') ? 'bg-white/15 text-white font-semibold shadow-lg shadow-green-900/20' : 'text-green-200 hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    Kelola Pengguna
                </a>

                <a href="{{ route('admin.gallery') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200 {{ request()->routeIs('admin.gallery') ? 'bg-white/15 text-white font-semibold shadow-lg shadow-green-900/20' : 'text-green-200 hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    Kelola Gallery
                </a>
                @endrole
            </nav>

            {{-- Logout --}}
            <div class="px-4 py-4 border-t border-green-600/30">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 w-full px-3 py-2.5 rounded-xl text-sm text-green-300 hover:bg-red-500/20 hover:text-red-200 transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Keluar
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main Content --}}
        <div class="flex-1 flex flex-col min-h-screen lg:ml-0">
            {{-- Top Bar --}}
            <header class="sticky top-0 z-30 bg-white/80 backdrop-blur-lg border-b border-gray-200/80 px-4 sm:px-6 lg:px-8 py-3">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <button @click="sidebarOpen = true" class="lg:hidden p-2 rounded-lg text-gray-500 hover:bg-gray-100">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        </button>
                        <h2 class="text-lg font-semibold text-gray-800">{{ $header ?? '' }}</h2>
                    </div>
                    <div class="text-xs text-gray-500">
                        {{ now()->translatedFormat('l, d F Y') }}
                    </div>
                </div>
            </header>

            {{-- Page Content --}}
            <main class="flex-1 p-4 sm:p-6 lg:p-8">
                {{-- Flash Messages --}}
                @if (session('success'))
                    <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm flex items-center gap-2" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-transition>
                        <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        {{ session('success') }}
                    </div>
                @endif

                {{ $slot }}
            </main>
        </div>
    </div>

    @livewireScripts
</body>
</html>
