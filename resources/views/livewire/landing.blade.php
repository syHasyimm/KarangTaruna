<div>
    {{-- Navbar --}}
    <nav class="bg-white/80 backdrop-blur-lg border-b border-gray-200/60 sticky top-0 z-50" x-data="{ mobileOpen: false }">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="flex items-center justify-between h-16">
                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex items-center gap-2.5 group">
                    <div class="w-9 h-9 bg-linear-to-br from-green-600 to-green-700 rounded-xl flex items-center justify-center shadow-sm group-hover:shadow-md transition-shadow">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                    </div>
                    <span class="font-bold text-gray-800 text-lg tracking-tight group-hover:text-green-700 transition">KarangTaruna</span>
                </a>

                {{-- Desktop Nav Links --}}
                <div class="hidden md:flex items-center gap-1">
                    <a href="#berita" class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-green-700 hover:bg-green-50 rounded-lg transition-all duration-200">Berita</a>
                    <a href="#sejarah" class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-green-700 hover:bg-green-50 rounded-lg transition-all duration-200">Sejarah</a>
                    <a href="#gallery" class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-green-700 hover:bg-green-50 rounded-lg transition-all duration-200">Gallery</a>
                    <a href="#voting" class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-green-700 hover:bg-green-50 rounded-lg transition-all duration-200">Voting</a>
                    <a href="#keuangan" class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-green-700 hover:bg-green-50 rounded-lg transition-all duration-200">Keuangan</a>
                </div>

                {{-- Auth Buttons --}}
                <div class="hidden md:flex items-center gap-2">
                    @auth
                        <span class="text-sm text-gray-500 mr-1">{{ auth()->user()->name }}</span>
                        @hasanyrole('admin|bendahara')
                        <a href="{{ route('dashboard') }}" class="px-4 py-2 text-sm font-medium text-green-700 hover:bg-green-50 rounded-lg transition">Dashboard</a>
                        @endhasanyrole
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="px-4 py-2 text-sm text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition font-medium">Keluar</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-green-700 hover:bg-green-50 rounded-lg transition">Masuk</a>
                        <a href="{{ route('register') }}" class="px-5 py-2 bg-green-600 text-white text-sm font-semibold rounded-lg hover:bg-green-700 transition shadow-sm shadow-green-500/20">Daftar</a>
                    @endauth
                </div>

                {{-- Mobile Menu Button --}}
                <div class="flex items-center gap-2 md:hidden">
                    <button @click="mobileOpen = !mobileOpen" class="p-2 rounded-lg text-gray-500 hover:bg-gray-100 transition">
                        <svg x-show="!mobileOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        <svg x-show="mobileOpen" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            </div>

            {{-- Mobile Menu --}}
            <div x-show="mobileOpen" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" class="md:hidden pb-4 border-t border-gray-100 mt-1">
                <div class="pt-3 space-y-1">
                    <a href="#berita" @click="mobileOpen = false" class="block px-4 py-2.5 text-sm font-medium text-gray-600 hover:text-green-700 hover:bg-green-50 rounded-lg transition">Berita</a>
                    <a href="#sejarah" @click="mobileOpen = false" class="block px-4 py-2.5 text-sm font-medium text-gray-600 hover:text-green-700 hover:bg-green-50 rounded-lg transition">Sejarah</a>
                    <a href="#gallery" @click="mobileOpen = false" class="block px-4 py-2.5 text-sm font-medium text-gray-600 hover:text-green-700 hover:bg-green-50 rounded-lg transition">Gallery</a>
                    <a href="#voting" @click="mobileOpen = false" class="block px-4 py-2.5 text-sm font-medium text-gray-600 hover:text-green-700 hover:bg-green-50 rounded-lg transition">Voting</a>
                    <a href="#keuangan" @click="mobileOpen = false" class="block px-4 py-2.5 text-sm font-medium text-gray-600 hover:text-green-700 hover:bg-green-50 rounded-lg transition">Keuangan</a>
                </div>
                <div class="pt-3 mt-2 border-t border-gray-100 space-y-1">
                    @auth
                        <div class="px-4 py-2 text-sm text-gray-500">{{ auth()->user()->name }}</div>
                        @hasanyrole('admin|bendahara')
                        <a href="{{ route('dashboard') }}" class="block px-4 py-2.5 text-sm font-medium text-green-700 hover:bg-green-50 rounded-lg transition">Dashboard</a>
                        @endhasanyrole
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 rounded-lg transition font-medium">Keluar</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="block px-4 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-50 rounded-lg transition">Masuk</a>
                        <a href="{{ route('register') }}" class="block px-4 py-2.5 text-sm font-medium text-white bg-green-600 hover:bg-green-700 rounded-lg transition text-center">Daftar Sebagai Warga</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    {{-- Hero Section --}}
    <section class="relative overflow-hidden bg-gradient-to-br from-green-700 via-green-800 to-green-900 text-white">
        <div class="absolute inset-0">
            <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-white/5 rounded-full -translate-y-1/2 translate-x-1/3 blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-96 h-96 bg-green-400/10 rounded-full translate-y-1/3 -translate-x-1/4 blur-2xl"></div>
            <div class="absolute top-1/2 left-1/2 w-72 h-72 bg-emerald-300/5 rounded-full -translate-x-1/2 -translate-y-1/2 blur-2xl"></div>
        </div>
        <div class="relative max-w-6xl mx-auto px-4 sm:px-6 py-24 sm:py-32 lg:py-36 text-center">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-white/10 backdrop-blur-sm rounded-full text-green-200 text-sm font-medium mb-8 border border-white/10">
                <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                Sistem Manajemen Desa Digital
            </div>
            <h1 class="text-4xl sm:text-5xl lg:text-6xl xl:text-7xl font-extrabold tracking-tight mb-6 leading-[1.1]">
                Karang Taruna
            </h1>
            <p class="text-green-100/80 text-lg sm:text-xl max-w-2xl mx-auto mb-10 leading-relaxed">
                Mewujudkan generasi muda yang aktif, kreatif, dan bertanggung jawab dalam pembangunan desa.
            </p>
            @guest
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <a href="{{ route('register') }}" class="px-8 py-3.5 bg-white text-green-800 rounded-xl font-semibold text-sm hover:bg-green-50 transition shadow-lg shadow-green-900/30 hover:shadow-xl hover:-translate-y-0.5 transform duration-200">
                    Daftar Sebagai Warga
                </a>
                <a href="{{ route('login') }}" class="px-8 py-3.5 border-2 border-white/20 text-white rounded-xl font-semibold text-sm hover:bg-white/10 hover:border-white/30 transition">
                    Masuk ke Akun
                </a>
            </div>
            @endguest
        </div>
        {{-- Wave divider --}}
        <div class="absolute bottom-0 left-0 right-0">
            <svg viewBox="0 0 1440 60" class="w-full h-auto fill-white" preserveAspectRatio="none">
                <path d="M0,40 C360,80 720,0 1080,40 C1260,60 1380,50 1440,40 L1440,60 L0,60 Z"/>
            </svg>
        </div>
    </section>

    {{-- Ketua Karang Taruna --}}
    @if($activeChairman)
    <section id="ketua" class="max-w-6xl mx-auto px-4 sm:px-6 py-20 scroll-mt-20">
        <div class="text-center mb-12">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700 mb-4">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                Pimpinan
            </span>
            <h2 class="text-3xl sm:text-4xl font-bold text-gray-800 mb-3">Ketua Karang Taruna</h2>
            <p class="text-gray-500 max-w-lg mx-auto">Profil ketua yang memimpin Karang Taruna saat ini</p>
        </div>
        <div class="max-w-3xl mx-auto">
            <div class="bg-white rounded-3xl border border-gray-100 shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <div class="flex flex-col md:flex-row">
                    {{-- Photo --}}
                    <div class="md:w-2/5 relative">
                        @if($activeChairman->photo)
                        <img src="{{ asset('storage/' . $activeChairman->photo) }}" alt="{{ $activeChairman->name }}" class="w-full h-64 md:h-full object-cover">
                        @else
                        <div class="w-full h-64 md:h-full bg-gradient-to-br from-green-100 to-green-200 flex items-center justify-center">
                            <svg class="w-24 h-24 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        @endif
                        <div class="absolute bottom-3 left-3 md:bottom-4 md:left-4">
                            <span class="px-3 py-1 bg-green-600/90 text-white text-xs font-semibold rounded-full backdrop-blur-sm shadow-sm">
                                Periode {{ $activeChairman->period }}
                            </span>
                        </div>
                    </div>
                    {{-- Info --}}
                    <div class="md:w-3/5 p-6 sm:p-8 flex flex-col justify-center">
                        <h3 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-1">{{ $activeChairman->name }}</h3>
                        <p class="text-green-600 font-semibold text-sm mb-4">Ketua Karang Taruna</p>

                        @if($activeChairman->formatted_birth)
                        <div class="flex items-center gap-3 text-gray-500 text-sm mb-4">
                            <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                            <span>{{ $activeChairman->formatted_birth }}</span>
                        </div>
                        @endif

                        @if($activeChairman->achievements && count($activeChairman->achievements) > 0)
                        <div class="border-t border-gray-100 pt-4 mt-auto">
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3 flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                                Prestasi
                            </p>
                            <ul class="space-y-2">
                                @foreach($activeChairman->achievements as $achievement)
                                <li class="flex items-start gap-2.5 text-sm text-gray-600">
                                    <div class="w-5 h-5 bg-green-100 rounded-full flex items-center justify-center shrink-0 mt-0.5">
                                        <svg class="w-3 h-3 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                    </div>
                                    {{ $achievement }}
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- Sejarah Karang Taruna --}}
    <section id="sejarah" class="bg-gradient-to-b from-gray-50 to-white py-20 scroll-mt-20">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="text-center mb-12">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-700 mb-4">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Sejarah
                </span>
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-800 mb-3">Sejarah Karang Taruna</h2>
                <p class="text-gray-500 max-w-lg mx-auto">Perjalanan panjang organisasi kepemudaan desa dalam membangun masyarakat</p>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
                <div class="space-y-6">
                    <div class="flex gap-4">
                        <div class="shrink-0 w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                            <span class="text-green-700 font-bold text-sm">1960</span>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-800 mb-1">Awal Berdiri</h4>
                            <p class="text-gray-500 text-sm leading-relaxed">Karang Taruna pertama kali lahir di Kampung Melayu, Jakarta, sebagai wadah pembinaan generasi muda dalam bidang kesejahteraan sosial.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="shrink-0 w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                            <span class="text-blue-700 font-bold text-sm">1981</span>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-800 mb-1">Pengakuan Nasional</h4>
                            <p class="text-gray-500 text-sm leading-relaxed">Ditetapkan secara resmi melalui Keputusan Menteri Sosial sebagai organisasi sosial kepemudaan tingkat desa/kelurahan di seluruh Indonesia.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="shrink-0 w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                            <span class="text-purple-700 font-bold text-sm">2010</span>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-800 mb-1">Era Modernisasi</h4>
                            <p class="text-gray-500 text-sm leading-relaxed">Karang Taruna mulai bertransformasi dengan memanfaatkan teknologi digital untuk meningkatkan transparansi dan partisipasi warga.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="shrink-0 w-12 h-12 bg-green-600 rounded-xl flex items-center justify-center">
                            <span class="text-white font-bold text-sm">Now</span>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-800 mb-1">Platform Digital</h4>
                            <p class="text-gray-500 text-sm leading-relaxed">Sistem manajemen desa digital yang memungkinkan transparansi keuangan, voting demokratis, dan penyebaran informasi kepada seluruh warga.</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8">
                    <div class="text-center mb-6">
                        <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-700 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg shadow-green-500/20">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Visi & Misi</h3>
                    </div>
                    <div class="space-y-4">
                        <div class="bg-green-50 rounded-xl p-4 border border-green-100">
                            <h4 class="font-semibold text-green-800 text-sm mb-1">🎯 Visi</h4>
                            <p class="text-green-700 text-sm">Mewujudkan generasi muda yang aktif, kreatif, dan bertanggung jawab dalam pembangunan desa.</p>
                        </div>
                        <div class="bg-blue-50 rounded-xl p-4 border border-blue-100">
                            <h4 class="font-semibold text-blue-800 text-sm mb-1">🚀 Misi</h4>
                            <ul class="text-blue-700 text-sm space-y-1.5">
                                <li class="flex items-start gap-2"><span class="text-blue-400 mt-0.5">•</span> Mendorong partisipasi aktif pemuda dalam kegiatan sosial</li>
                                <li class="flex items-start gap-2"><span class="text-blue-400 mt-0.5">•</span> Transparansi pengelolaan keuangan organisasi</li>
                                <li class="flex items-start gap-2"><span class="text-blue-400 mt-0.5">•</span> Membangun mekanisme pengambilan keputusan yang demokratis</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Gallery Section --}}
    <section id="gallery" class="max-w-6xl mx-auto px-4 sm:px-6 py-20 scroll-mt-20" x-data="{ activeCategory: 'all' }">
        <div class="text-center mb-12">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-700 mb-4">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Gallery
            </span>
            <h2 class="text-3xl sm:text-4xl font-bold text-gray-800 mb-3">Galeri Kegiatan</h2>
            <p class="text-gray-500 max-w-lg mx-auto">Dokumentasi kegiatan dan momen penting Karang Taruna</p>
        </div>

        {{-- Category Filter Tabs --}}
        @if($galleryCategories->count() > 0 && $galleries->count() > 0)
        <div class="flex flex-wrap justify-center gap-2 mb-8">
            <button @click="activeCategory = 'all'" :class="activeCategory === 'all' ? 'bg-green-600 text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'" class="px-4 py-2 rounded-full text-sm font-medium transition">
                Semua
            </button>
            @foreach($galleryCategories as $cat)
            @if($cat->active_galleries_count > 0)
            <button @click="activeCategory = '{{ $cat->slug }}'" :class="activeCategory === '{{ $cat->slug }}' ? 'bg-green-600 text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'" class="px-4 py-2 rounded-full text-sm font-medium transition">
                {{ $cat->name }}
            </button>
            @endif
            @endforeach
        </div>
        @endif

        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
            @forelse($galleries as $gallery)
            <div
                x-show="activeCategory === 'all' || activeCategory === '{{ $gallery->category?->slug }}'"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                class="group relative overflow-hidden rounded-2xl aspect-square hover:shadow-xl transition-shadow duration-300"
            >
                <img src="{{ asset('storage/' . $gallery->image) }}" alt="{{ $gallery->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end">
                    <div class="p-4 w-full">
                        @if($gallery->category)
                        <span class="inline-block px-2 py-0.5 bg-white/20 text-white text-[10px] font-medium rounded-full mb-1 backdrop-blur-sm">{{ $gallery->category->name }}</span>
                        @endif
                        <h4 class="text-white font-semibold text-sm">{{ $gallery->title }}</h4>
                        @if($gallery->description)
                        <p class="text-white/70 text-xs mt-0.5">{{ $gallery->description }}</p>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            {{-- Placeholder cards when gallery is empty --}}
            @php $placeholders = [
                ['color' => 'green', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z', 'label' => 'Gotong Royong'],
                ['color' => 'blue', 'icon' => 'M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9', 'label' => 'Musyawarah'],
                ['color' => 'amber', 'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253', 'label' => 'Pelatihan'],
                ['color' => 'rose', 'icon' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z', 'label' => 'Bakti Sosial'],
                ['color' => 'cyan', 'icon' => 'M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'label' => 'Olahraga'],
                ['color' => 'indigo', 'icon' => 'M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z', 'label' => 'Inovasi'],
            ]; @endphp
            @foreach($placeholders as $p)
            <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-{{ $p['color'] }}-200 to-{{ $p['color'] }}-300 aspect-square hover:shadow-xl transition-shadow duration-300">
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="text-center">
                        <svg class="w-12 h-12 text-{{ $p['color'] }}-500/60 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $p['icon'] }}"/></svg>
                        <p class="text-{{ $p['color'] }}-700 font-semibold text-sm">{{ $p['label'] }}</p>
                    </div>
                </div>
                <div class="absolute inset-0 bg-{{ $p['color'] }}-800/60 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                    <p class="text-white font-semibold">{{ $p['label'] }}</p>
                </div>
            </div>
            @endforeach
            @endforelse
        </div>
    </section>

    {{-- Fitur Utama --}}
    <section class="bg-linear-to-b from-gray-50 to-white py-20">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="text-center mb-12">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700 mb-4">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    Fitur
                </span>
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-800 mb-3">Fitur Utama</h2>
                <p class="text-gray-500 max-w-lg mx-auto">Semua yang dibutuhkan warga dalam satu platform digital</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white rounded-2xl p-7 border border-gray-100 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group">
                    <div class="w-14 h-14 bg-gradient-to-br from-green-100 to-emerald-100 rounded-2xl flex items-center justify-center mb-5 group-hover:from-green-200 group-hover:to-emerald-200 transition-all duration-300">
                        <svg class="w-7 h-7 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="font-bold text-gray-800 text-lg mb-2">Transparansi Keuangan</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Lihat saldo kas, pemasukan, dan pengeluaran Karang Taruna secara real-time dan transparan.</p>
                </div>
                <div class="bg-white rounded-2xl p-7 border border-gray-100 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group">
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-100 to-indigo-100 rounded-2xl flex items-center justify-center mb-5 group-hover:from-blue-200 group-hover:to-indigo-200 transition-all duration-300">
                        <svg class="w-7 h-7 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                    </div>
                    <h3 class="font-bold text-gray-800 text-lg mb-2">Voting Demokratis</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Berpartisipasi dalam pengambilan keputusan melalui sistem voting yang adil dan terbuka.</p>
                </div>
                <div class="bg-white rounded-2xl p-7 border border-gray-100 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group">
                    <div class="w-14 h-14 bg-gradient-to-br from-amber-100 to-orange-100 rounded-2xl flex items-center justify-center mb-5 group-hover:from-amber-200 group-hover:to-orange-200 transition-all duration-300">
                        <svg class="w-7 h-7 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                    </div>
                    <h3 class="font-bold text-gray-800 text-lg mb-2">Berita Desa</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Informasi terkini seputar kegiatan dan pengumuman Karang Taruna untuk semua warga.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Voting Aktif --}}
    @if($activeEvents->count() > 0)
    <section id="voting" class="max-w-6xl mx-auto px-4 sm:px-6 py-20 scroll-mt-20">
        <div class="text-center mb-12">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700 mb-4">
                <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                Live
            </span>
            <h2 class="text-3xl sm:text-4xl font-bold text-gray-800 mb-3">Voting Aktif</h2>
            <p class="text-gray-500 max-w-lg mx-auto">Berikan suara Anda untuk keputusan penting desa</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($activeEvents as $event)
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group">
                <div class="flex items-center gap-2 mb-4">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                        <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></span>
                        Dibuka
                    </span>
                </div>
                <h3 class="font-bold text-gray-800 text-lg mb-2 group-hover:text-green-700 transition">{{ $event->title }}</h3>
                <p class="text-gray-500 text-sm mb-5 line-clamp-2 leading-relaxed">{{ $event->description ?? 'Tidak ada deskripsi.' }}</p>
                <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                    <span class="text-xs text-gray-400 font-medium">{{ $event->votes_count }} suara</span>
                    @auth
                    <a href="{{ route('voting.warga.show', $event) }}" class="px-5 py-2 bg-green-600 text-white rounded-lg text-xs font-semibold hover:bg-green-700 transition shadow-sm shadow-green-500/20">Vote Sekarang</a>
                    @else
                    <a href="{{ route('register') }}" class="px-5 py-2 bg-green-600 text-white rounded-lg text-xs font-semibold hover:bg-green-700 transition shadow-sm shadow-green-500/20">Daftar untuk Vote</a>
                    @endauth
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endif

    {{-- Berita Terbaru --}}
    @if($latestNews->count() > 0)
    <section id="berita" class="bg-linear-to-b from-gray-50 to-white py-20 scroll-mt-20">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="text-center mb-12">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-700 mb-4">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                    Berita
                </span>
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-800 mb-3">Berita Terbaru</h2>
                <p class="text-gray-500 max-w-lg mx-auto">Kabar dan pengumuman terkini dari Karang Taruna</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($latestNews as $news)
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group h-full flex flex-col">
                    <a href="{{ route('news.show', $news) }}" class="block relative overflow-hidden h-48">
                        @if($news->thumbnail)
                        <img src="{{ asset('storage/' . $news->thumbnail) }}" alt="{{ $news->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                        <div class="w-full h-full bg-gradient-to-br from-green-100 to-emerald-200 flex items-center justify-center">
                            <svg class="w-12 h-12 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                        </div>
                        @endif
                        <div class="absolute inset-0 bg-linear-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </a>
                    <div class="p-6 flex-1 flex flex-col">
                        <p class="text-xs text-gray-400 mb-2 font-medium">{{ $news->created_at->diffForHumans() }}</p>
                        <a href="{{ route('news.show', $news) }}" class="block mb-3">
                            <h3 class="font-bold text-gray-800 group-hover:text-green-700 transition line-clamp-2 leading-snug">{{ $news->title }}</h3>
                        </a>
                        <p class="text-gray-500 text-sm line-clamp-3 mb-5 flex-1 leading-relaxed">{{ Str::limit(strip_tags($news->content), 100) }}</p>
                        <a href="{{ route('news.show', $news) }}" class="text-green-600 text-sm font-semibold hover:text-green-700 inline-flex items-center gap-1.5 mt-auto group/link">
                            Baca Selengkapnya
                            <svg class="w-4 h-4 group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- Footer --}}
    <footer class="bg-linear-to-b from-green-900 to-green-950 text-green-300 pt-16 pb-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10 mb-12">
                <div>
                    <div class="flex items-center gap-2.5 mb-4">
                        <div class="w-9 h-9 bg-white/10 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        </div>
                        <span class="font-bold text-white text-lg">KarangTaruna</span>
                    </div>
                    <p class="text-sm leading-relaxed text-green-400">Sistem Manajemen Desa Digital — Mendorong transparansi, partisipasi, dan modernisasi desa.</p>
                </div>
                <div>
                    <h4 class="font-semibold text-white text-sm mb-4">Menu</h4>
                    <div class="space-y-2.5">
                        <a href="#berita" class="block text-sm text-green-400 hover:text-white transition">Berita</a>
                        <a href="#sejarah" class="block text-sm text-green-400 hover:text-white transition">Sejarah</a>
                        <a href="#gallery" class="block text-sm text-green-400 hover:text-white transition">Gallery</a>
                        <a href="#voting" class="block text-sm text-green-400 hover:text-white transition">Voting</a>
                        <a href="#keuangan" class="block text-sm text-green-400 hover:text-white transition">Keuangan</a>
                    </div>
                </div>
                <div>
                    <h4 class="font-semibold text-white text-sm mb-4">Kontak</h4>
                    <div class="space-y-2.5">
                        <p class="text-sm text-green-400 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            Alamat Desa
                        </p>
                        <p class="text-sm text-green-400 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            karangtaruna@desa.id
                        </p>
                    </div>
                </div>
            </div>
            <div class="border-t border-green-800/50 pt-6 text-center">
                <p class="text-xs text-green-500">&copy; {{ date('Y') }} KarangTaruna. Semua hak dilindungi.</p>
            </div>
        </div>
    </footer>
</div>
