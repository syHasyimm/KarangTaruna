<div>
    {{-- Navbar --}}
    <nav class="bg-white border-b border-gray-100 sticky top-0 z-30">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-3 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                <div class="w-9 h-9 bg-gradient-to-br from-green-600 to-green-700 rounded-xl flex items-center justify-center shadow-sm">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                </div>
                <span class="font-bold text-gray-800 text-lg group-hover:text-green-700 transition">KarangTaruna</span>
            </a>
            <div class="flex items-center gap-3">
                @auth
                <span class="text-sm text-gray-500 hidden sm:inline">{{ auth()->user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="px-4 py-2 text-sm text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition font-medium">
                        Keluar
                    </button>
                </form>
                @else
                <a href="{{ route('login') }}" class="px-4 py-2 text-sm text-gray-600 hover:text-green-700 font-medium transition">Masuk</a>
                <a href="{{ route('register') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg text-sm font-medium hover:bg-green-700 transition">Daftar</a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- Hero Banner --}}
    <div class="bg-gradient-to-r from-green-700 via-green-800 to-green-900 text-white relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 right-0 w-72 h-72 bg-white rounded-full -translate-y-1/2 translate-x-1/3"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-white rounded-full translate-y-1/3 -translate-x-1/4"></div>
        </div>
        <div class="relative max-w-4xl mx-auto px-4 sm:px-6 py-8 sm:py-10">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-green-200 text-sm hover:text-white transition mb-4">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Kembali ke Beranda
            </a>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                    <svg class="w-5 h-5 text-green-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold tracking-tight">Berita Desa</h1>
                    <p class="text-green-200 text-sm">Informasi & pengumuman terkini</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Article Content --}}
    <div class="max-w-4xl mx-auto px-4 sm:px-6 py-8 sm:py-12">
        <article class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            @if($news->thumbnail)
            <div class="h-64 sm:h-80 lg:h-96 overflow-hidden">
                <img src="{{ asset('storage/' . $news->thumbnail) }}" alt="{{ $news->title }}" class="w-full h-full object-cover">
            </div>
            @endif
            <div class="p-6 sm:p-8 lg:p-10">
                <div class="flex items-center gap-3 mb-4">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        {{ $news->created_at->translatedFormat('l, d F Y') }}
                    </span>
                </div>
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-6 leading-tight">{{ $news->title }}</h2>
                <div class="prose prose-green max-w-none text-gray-600 leading-relaxed">
                    {!! nl2br(e($news->content)) !!}
                </div>
            </div>
        </article>

        {{-- Back Button --}}
        <div class="mt-8 text-center">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-white text-green-700 rounded-xl text-sm font-medium hover:bg-green-50 transition border border-green-200 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Kembali ke Beranda
            </a>
        </div>
    </div>

    {{-- Footer --}}
    <footer class="bg-green-900 text-green-300 py-8 mt-auto">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 text-center">
            <div class="inline-flex items-center gap-2 mb-3">
                <div class="w-7 h-7 bg-white/10 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                </div>
                <span class="font-bold text-white">KarangTaruna</span>
            </div>
            <p class="text-sm mb-2">Sistem Manajemen Desa — Transparan, Demokratis, dan Modern.</p>
            <p class="text-xs text-green-400">&copy; {{ date('Y') }} KarangTaruna. Semua hak dilindungi.</p>
        </div>
    </footer>
</div>
