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
                <span class="text-sm text-gray-500 hidden sm:inline">{{ auth()->user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="px-4 py-2 text-sm text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition font-medium">
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </nav>

    {{-- Hero Banner --}}
    <div class="bg-gradient-to-r from-green-700 via-green-800 to-green-900 text-white relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 right-0 w-72 h-72 bg-white rounded-full -translate-y-1/2 translate-x-1/3"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-white rounded-full translate-y-1/3 -translate-x-1/4"></div>
        </div>
        <div class="relative max-w-6xl mx-auto px-4 sm:px-6 py-8 sm:py-10">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-green-200 text-sm hover:text-white transition mb-4">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Kembali ke Beranda
            </a>
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                    <svg class="w-5 h-5 text-green-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold tracking-tight">{{ $event->title }}</h1>
                    <p class="text-green-200 text-sm">Tahun {{ $event->year }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-8 sm:py-12">
        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm flex items-center gap-2" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-transition>
                <svg class="w-5 h-5 text-green-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm flex items-center gap-2" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-transition>
                <svg class="w-5 h-5 text-red-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-7a1 1 0 112 0v2a1 1 0 11-2 0v-2zm1-5a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"/></svg>
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Voting Form --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                        <div class="flex items-center gap-3">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
                                {{ $event->status === 'open' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                                {{ $event->status === 'open' ? 'Dibuka' : ($event->status === 'draft' ? 'Draft' : 'Ditutup') }}
                            </span>
                            <span class="text-sm text-gray-400">{{ $event->type === 'multiple_choice' ? 'Pilihan Ganda' : 'Setuju / Tidak Setuju' }}</span>
                        </div>
                    </div>

                    <div class="p-6">
                        <p class="text-gray-500 mb-6">{{ $event->description ?? 'Tidak ada deskripsi.' }}</p>

                        @if($event->status === 'open' && !$hasVoted)
                        <form wire:submit="submitVote" class="space-y-5">
                            <p class="font-semibold text-gray-700">{{ $event->type === 'multiple_choice' ? 'Pilih salah satu opsi:' : 'Apakah Anda setuju?' }}</p>
                            <div class="space-y-3">
                                @php
                                    $options = $event->type === 'multiple_choice' ? $event->options : ['Setuju', 'Tidak Setuju', 'Abstain'];
                                    $colors = ['green', 'blue', 'purple', 'amber', 'rose'];
                                @endphp
                                @foreach($options as $index => $option)
                                <label class="flex items-center gap-4 p-4 border-2 rounded-xl cursor-pointer transition-all duration-200
                                    {{ $choice === $option
                                        ? 'border-green-500 bg-green-50 ring-2 ring-green-500/20 shadow-sm'
                                        : 'border-gray-200 hover:border-green-300 hover:bg-green-50/30' }}">
                                    <div class="relative flex items-center justify-center">
                                        <input wire:model="choice" type="radio" value="{{ $option }}" class="sr-only peer">
                                        <div class="w-5 h-5 rounded-full border-2 transition-all duration-200
                                            {{ $choice === $option ? 'border-green-500 bg-green-500' : 'border-gray-300' }}">
                                            @if($choice === $option)
                                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                            @endif
                                        </div>
                                    </div>
                                    <span class="text-sm font-medium {{ $choice === $option ? 'text-green-700' : 'text-gray-700' }}">{{ $option }}</span>
                                </label>
                                @endforeach
                            </div>
                            @error('choice') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                            <button type="submit"
                                class="w-full py-3.5 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-xl font-semibold text-sm hover:from-green-700 hover:to-green-800 transition-all duration-200 shadow-lg shadow-green-500/25 flex items-center justify-center gap-2"
                                wire:loading.attr="disabled"
                                wire:loading.class="opacity-70 cursor-not-allowed">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span wire:loading.remove>Kirim Suara Saya</span>
                                <span wire:loading>Mengirim...</span>
                            </button>
                        </form>
                        @elseif($hasVoted)
                        <div class="p-8 bg-gradient-to-br from-green-50 to-emerald-50 border border-green-200 rounded-2xl text-center">
                            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <p class="text-green-700 font-bold text-lg">Anda sudah memberikan suara</p>
                            <p class="text-green-600 text-sm mt-1">Terima kasih atas partisipasi Anda!</p>
                            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 mt-4 px-5 py-2.5 bg-white text-green-700 rounded-xl text-sm font-medium hover:bg-green-50 transition border border-green-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                Kembali ke Beranda
                            </a>
                        </div>
                        @else
                        <div class="p-8 bg-gray-50 border border-gray-200 rounded-2xl text-center">
                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            </div>
                            <p class="text-gray-600 font-semibold">Voting ini {{ $event->status === 'draft' ? 'belum dibuka' : 'sudah ditutup' }}.</p>
                            <p class="text-gray-400 text-sm mt-1">Silakan cek kembali nanti atau lihat voting lain yang tersedia.</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Results Sidebar --}}
            <div>
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                        <h3 class="font-semibold text-gray-800">Hasil Sementara</h3>
                    </div>
                    <div class="p-6">
                        <div class="text-center mb-5">
                            <p class="text-4xl font-bold text-gray-800">{{ $totalVotes }}</p>
                            <p class="text-sm text-gray-400 mt-1">total suara masuk</p>
                        </div>
                        <div class="space-y-4">
                            @forelse($results as $choiceLabel => $count)
                            @php $percentage = $totalVotes > 0 ? round(($count / $totalVotes) * 100) : 0; @endphp
                            <div>
                                <div class="flex justify-between text-sm mb-1.5">
                                    <span class="text-gray-700 font-medium">{{ $choiceLabel }}</span>
                                    <span class="text-gray-500 font-semibold">{{ $percentage }}%</span>
                                </div>
                                <div class="w-full bg-gray-100 rounded-full h-3 overflow-hidden">
                                    <div class="bg-gradient-to-r from-green-400 to-green-600 h-3 rounded-full transition-all duration-700 ease-out" style="width: {{ $percentage }}%"></div>
                                </div>
                                <p class="text-xs text-gray-400 mt-1">{{ $count }} suara</p>
                            </div>
                            @empty
                            <div class="text-center py-4">
                                <svg class="w-10 h-10 text-gray-200 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                                <p class="text-gray-400 text-sm">Belum ada suara masuk.</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
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
