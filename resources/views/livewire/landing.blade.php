<div>
    {{-- Hero Section --}}
    <section class="relative overflow-hidden bg-gradient-to-br from-green-700 via-green-800 to-green-900 text-white">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 right-0 w-96 h-96 bg-white rounded-full -translate-y-1/2 translate-x-1/3"></div>
            <div class="absolute bottom-0 left-0 w-72 h-72 bg-white rounded-full translate-y-1/3 -translate-x-1/4"></div>
        </div>
        <div class="relative max-w-6xl mx-auto px-4 sm:px-6 py-20 sm:py-28 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-white/20 rounded-2xl backdrop-blur-sm mb-6">
                <svg class="w-8 h-8 text-green-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
            </div>
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight mb-4">Karang Taruna</h1>
            <p class="text-green-100 text-lg sm:text-xl max-w-2xl mx-auto mb-8">Sistem Manajemen Desa — Transparansi keuangan, voting demokratis, dan informasi terkini untuk seluruh warga.</p>
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <a href="{{ route('register') }}" class="px-8 py-3.5 bg-white text-green-800 rounded-xl font-semibold text-sm hover:bg-green-50 transition shadow-lg shadow-green-900/30">
                    Daftar Sebagai Warga
                </a>
                <a href="{{ route('login') }}" class="px-8 py-3.5 border-2 border-white/30 text-white rounded-xl font-semibold text-sm hover:bg-white/10 transition">
                    Masuk
                </a>
            </div>
        </div>
    </section>

    {{-- Transparansi Keuangan --}}
    <section class="max-w-6xl mx-auto px-4 sm:px-6 py-16">
        <div class="text-center mb-10">
            <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-2">Transparansi Kas Desa</h2>
            <p class="text-gray-500">Saldo dan ringkasan keuangan Karang Taruna yang dapat diakses semua warga</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div class="bg-gradient-to-br from-green-500 to-green-700 rounded-2xl p-6 text-white shadow-lg shadow-green-500/20 text-center relative overflow-hidden">
                <div class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-full -translate-y-6 translate-x-6"></div>
                <p class="text-green-100 text-sm font-medium mb-1">Saldo Kas Saat Ini</p>
                <p class="text-3xl font-bold">Rp {{ number_format($balance, 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm text-center">
                <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center mx-auto mb-2">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"/></svg>
                </div>
                <p class="text-gray-500 text-sm mb-1">Total Pemasukan</p>
                <p class="text-2xl font-bold text-gray-800">Rp {{ number_format($totalIncome, 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm text-center">
                <div class="w-10 h-10 bg-red-100 rounded-xl flex items-center justify-center mx-auto mb-2">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"/></svg>
                </div>
                <p class="text-gray-500 text-sm mb-1">Total Pengeluaran</p>
                <p class="text-2xl font-bold text-gray-800">Rp {{ number_format($totalExpense, 0, ',', '.') }}</p>
            </div>
        </div>
    </section>

    {{-- Fitur Utama --}}
    <section class="bg-gray-50 py-16">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="text-center mb-10">
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-2">Fitur Utama</h2>
                <p class="text-gray-500">Semua yang dibutuhkan warga dalam satu platform</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-md transition group">
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mb-4 group-hover:bg-green-200 transition">
                        <svg class="w-6 h-6 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="font-semibold text-gray-800 text-lg mb-2">Transparansi Keuangan</h3>
                    <p class="text-gray-500 text-sm">Lihat saldo kas, pemasukan, dan pengeluaran Karang Taruna secara real-time.</p>
                </div>
                <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-md transition group">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mb-4 group-hover:bg-blue-200 transition">
                        <svg class="w-6 h-6 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                    </div>
                    <h3 class="font-semibold text-gray-800 text-lg mb-2">Voting Demokratis</h3>
                    <p class="text-gray-500 text-sm">Berpartisipasi dalam pengambilan keputusan melalui sistem voting yang adil.</p>
                </div>
                <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-md transition group">
                    <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center mb-4 group-hover:bg-amber-200 transition">
                        <svg class="w-6 h-6 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                    </div>
                    <h3 class="font-semibold text-gray-800 text-lg mb-2">Berita Desa</h3>
                    <p class="text-gray-500 text-sm">Informasi terkini seputar kegiatan dan pengumuman Karang Taruna.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Voting Aktif --}}
    @if($activeEvents->count() > 0)
    <section class="max-w-6xl mx-auto px-4 sm:px-6 py-16">
        <div class="text-center mb-10">
            <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-2">Voting Aktif</h2>
            <p class="text-gray-500">Berikan suara Anda untuk keputusan penting desa</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($activeEvents as $event)
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 hover:shadow-md transition">
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700 mb-3">Dibuka</span>
                <h3 class="font-semibold text-gray-800 text-lg mb-2">{{ $event->title }}</h3>
                <p class="text-gray-500 text-sm mb-4 line-clamp-2">{{ $event->description ?? 'Tidak ada deskripsi.' }}</p>
                <div class="flex items-center justify-between">
                    <span class="text-xs text-gray-400">{{ $event->votes_count }} suara</span>
                    @auth
                    <a href="{{ route('voting.show', $event) }}" class="px-4 py-2 bg-green-600 text-white rounded-lg text-xs font-medium hover:bg-green-700 transition">Vote Sekarang</a>
                    @else
                    <a href="{{ route('register') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg text-xs font-medium hover:bg-green-700 transition">Daftar untuk Vote</a>
                    @endauth
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endif

    {{-- Berita Terbaru --}}
    @if($latestNews->count() > 0)
    <section class="bg-gray-50 py-16">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="text-center mb-10">
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-2">Berita Terbaru</h2>
                <p class="text-gray-500">Kabar dan pengumuman terkini dari Karang Taruna</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($latestNews as $news)
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden hover:shadow-md transition group">
                    @if($news->thumbnail)
                    <div class="h-44 overflow-hidden">
                        <img src="{{ asset('storage/' . $news->thumbnail) }}" alt="{{ $news->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    </div>
                    @else
                    <div class="h-44 bg-gradient-to-br from-green-100 to-green-200 flex items-center justify-center">
                        <svg class="w-12 h-12 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                    </div>
                    @endif
                    <div class="p-5">
                        <p class="text-xs text-gray-400 mb-2">{{ $news->created_at->diffForHumans() }}</p>
                        <h3 class="font-semibold text-gray-800 mb-2 group-hover:text-green-700 transition">{{ $news->title }}</h3>
                        <p class="text-gray-500 text-sm line-clamp-2">{{ Str::limit(strip_tags($news->content), 100) }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- Footer --}}
    <footer class="bg-green-900 text-green-300 py-10">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 text-center">
            <div class="inline-flex items-center gap-2 mb-4">
                <div class="w-8 h-8 bg-white/10 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                </div>
                <span class="font-bold text-white">KarangTaruna</span>
            </div>
            <p class="text-sm mb-2">Sistem Manajemen Desa — Transparan, Demokratis, dan Modern.</p>
            <p class="text-xs text-green-400">&copy; {{ date('Y') }} KarangTaruna. Semua hak dilindungi.</p>
        </div>
    </footer>
</div>
