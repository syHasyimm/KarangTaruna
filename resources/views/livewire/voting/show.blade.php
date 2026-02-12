<div>
    <div class="mb-6">
        <a href="{{ route('voting.index') }}" class="text-green-600 text-sm hover:underline flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali ke Daftar Voting
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Voting Form --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <div class="flex items-center gap-3 mb-4">
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
                        {{ $event->status === 'open' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                        {{ $event->status === 'open' ? 'Dibuka' : ($event->status === 'draft' ? 'Draft' : 'Ditutup') }}
                    </span>
                    <span class="text-sm text-gray-400">Tahun {{ $event->year }}</span>
                </div>
                <h2 class="text-2xl font-bold text-gray-800 mb-2">{{ $event->title }}</h2>
                <p class="text-gray-500 mb-6">{{ $event->description ?? 'Tidak ada deskripsi.' }}</p>

                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm">{{ session('error') }}</div>
                @endif

                @if($event->status === 'open' && !$hasVoted)
                <form wire:submit="submitVote" class="space-y-4">
                    <p class="font-medium text-gray-700 mb-3">Pilih salah satu:</p>
                    <div class="space-y-2">
                        @foreach(['Setuju', 'Tidak Setuju', 'Abstain'] as $option)
                        <label class="flex items-center gap-3 p-4 border rounded-xl cursor-pointer transition-all duration-200 {{ $choice === $option ? 'border-green-500 bg-green-50 ring-2 ring-green-500/20' : 'border-gray-200 hover:border-green-300 hover:bg-green-50/50' }}">
                            <input wire:model="choice" type="radio" value="{{ $option }}" class="text-green-600 focus:ring-green-500">
                            <span class="text-sm font-medium {{ $choice === $option ? 'text-green-700' : 'text-gray-700' }}">{{ $option }}</span>
                        </label>
                        @endforeach
                    </div>
                    @error('choice') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                    <button type="submit" class="w-full py-3 bg-green-600 text-white rounded-xl font-semibold text-sm hover:bg-green-700 transition shadow-lg shadow-green-500/20" wire:loading.attr="disabled">
                        Kirim Suara
                    </button>
                </form>
                @elseif($hasVoted)
                <div class="p-6 bg-green-50 border border-green-200 rounded-xl text-center">
                    <svg class="w-12 h-12 text-green-500 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p class="text-green-700 font-semibold">Anda sudah memberikan suara</p>
                    <p class="text-green-600 text-sm mt-1">Terima kasih atas partisipasi Anda!</p>
                </div>
                @else
                <div class="p-6 bg-gray-50 border border-gray-200 rounded-xl text-center">
                    <p class="text-gray-500">Voting ini {{ $event->status === 'draft' ? 'belum dibuka' : 'sudah ditutup' }}.</p>
                </div>
                @endif
            </div>
        </div>

        {{-- Results Sidebar --}}
        <div>
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h3 class="font-semibold text-gray-800 mb-4">Hasil Sementara</h3>
                <p class="text-3xl font-bold text-gray-800 mb-4">{{ $totalVotes }} <span class="text-sm font-normal text-gray-400">suara</span></p>
                <div class="space-y-3">
                    @forelse($results as $choice => $count)
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-700 font-medium">{{ $choice }}</span>
                            <span class="text-gray-500">{{ $totalVotes > 0 ? round(($count / $totalVotes) * 100) : 0 }}%</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-2.5">
                            <div class="bg-green-500 h-2.5 rounded-full transition-all duration-500" style="width: {{ $totalVotes > 0 ? ($count / $totalVotes) * 100 : 0 }}%"></div>
                        </div>
                        <p class="text-xs text-gray-400 mt-0.5">{{ $count }} suara</p>
                    </div>
                    @empty
                    <p class="text-gray-400 text-sm">Belum ada suara masuk.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
