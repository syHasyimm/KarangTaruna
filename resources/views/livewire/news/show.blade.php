<div>
    <div class="mb-6">
        <a href="{{ route('news.index') }}" class="text-green-600 text-sm hover:underline flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali ke Berita
        </a>
    </div>

    <article class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        @if($news->thumbnail)
        <div class="h-64 sm:h-80 overflow-hidden">
            <img src="{{ asset('storage/' . $news->thumbnail) }}" alt="{{ $news->title }}" class="w-full h-full object-cover">
        </div>
        @endif
        <div class="p-6 sm:p-8">
            <p class="text-sm text-gray-400 mb-3">{{ $news->created_at->translatedFormat('l, d F Y') }}</p>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-6">{{ $news->title }}</h1>
            <div class="prose prose-green max-w-none text-gray-600 leading-relaxed">
                {!! nl2br(e($news->content)) !!}
            </div>
        </div>
    </article>
</div>
