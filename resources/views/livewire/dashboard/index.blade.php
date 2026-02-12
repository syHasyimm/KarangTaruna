<div>
    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mb-8">
        {{-- Saldo --}}
        <div class="bg-linear-to-br from-green-500 to-green-700 rounded-2xl p-6 text-white shadow-lg shadow-green-500/20 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-8 translate-x-8"></div>
            <div class="relative">
                <div class="flex items-center gap-2 mb-2">
                    <svg class="w-5 h-5 text-green-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                    <p class="text-green-100 text-sm font-medium">Saldo Kas Saat Ini</p>
                </div>
                <p class="text-3xl font-bold tracking-tight">Rp {{ number_format($balance, 0, ',', '.') }}</p>
            </div>
        </div>

        {{-- Pemasukan --}}
        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center gap-2 mb-2">
                <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"/></svg>
                </div>
                <p class="text-gray-500 text-sm">Total Pemasukan</p>
            </div>
            <p class="text-2xl font-bold text-gray-800">Rp {{ number_format($totalIncome, 0, ',', '.') }}</p>
        </div>

        {{-- Pengeluaran --}}
        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center gap-2 mb-2">
                <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"/></svg>
                </div>
                <p class="text-gray-500 text-sm">Total Pengeluaran</p>
            </div>
            <p class="text-2xl font-bold text-gray-800">Rp {{ number_format($totalExpense, 0, ',', '.') }}</p>
        </div>
    </div>

    {{-- Chart Section --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-8">
        <h3 class="text-base font-semibold text-gray-800 mb-4">Grafik Keuangan 6 Bulan Terakhir</h3>
        <div class="relative h-64" x-data="chartData()" x-init="initChart()">
            <canvas id="financeChart"></canvas>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Recent Transactions --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="font-semibold text-gray-800">Transaksi Terbaru</h3>
                @hasanyrole('admin|bendahara')
                <a href="{{ route('finance.index') }}" class="text-green-600 text-sm hover:underline">Lihat Semua</a>
                @endhasanyrole
            </div>
            <div class="divide-y divide-gray-50">
                @forelse($recentTransactions as $trx)
                <div class="px-6 py-3 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center {{ $trx->category->type === 'income' ? 'bg-emerald-100' : 'bg-red-100' }}">
                            @if($trx->category->type === 'income')
                                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"/></svg>
                            @else
                                <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"/></svg>
                            @endif
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-800">{{ $trx->category->name }}</p>
                            <p class="text-xs text-gray-400">{{ $trx->date->translatedFormat('d M Y') }}</p>
                        </div>
                    </div>
                    <p class="text-sm font-semibold {{ $trx->category->type === 'income' ? 'text-emerald-600' : 'text-red-600' }}">
                        {{ $trx->category->type === 'income' ? '+' : '-' }} Rp {{ number_format($trx->amount, 0, ',', '.') }}
                    </p>
                </div>
                @empty
                <div class="px-6 py-8 text-center text-gray-400 text-sm">Belum ada transaksi.</div>
                @endforelse
            </div>
        </div>

        {{-- Latest News & Voting --}}
        <div class="space-y-6">
            {{-- Active Voting --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="font-semibold text-gray-800">Voting Aktif</h3>
                    <a href="{{ route('voting.index') }}" class="text-green-600 text-sm hover:underline">Lihat Semua</a>
                </div>
                <div class="divide-y divide-gray-50">
                    @forelse($activeEvents as $event)
                    <a href="{{ route('voting.show', $event) }}" class="block px-6 py-3 hover:bg-gray-50 transition">
                        <p class="text-sm font-medium text-gray-800">{{ $event->title }}</p>
                        <p class="text-xs text-gray-400">{{ $event->votes_count }} suara masuk</p>
                    </a>
                    @empty
                    <div class="px-6 py-6 text-center text-gray-400 text-sm">Tidak ada voting aktif.</div>
                    @endforelse
                </div>
            </div>

            {{-- Latest News --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="font-semibold text-gray-800">Berita Terbaru</h3>
                    <a href="{{ route('news.index') }}" class="text-green-600 text-sm hover:underline">Lihat Semua</a>
                </div>
                <div class="divide-y divide-gray-50">
                    @forelse($latestNews as $item)
                    <a href="{{ route('news.show', $item) }}" class="block px-6 py-3 hover:bg-gray-50 transition">
                        <p class="text-sm font-medium text-gray-800">{{ $item->title }}</p>
                        <p class="text-xs text-gray-400">{{ $item->created_at->diffForHumans() }}</p>
                    </a>
                    @empty
                    <div class="px-6 py-6 text-center text-gray-400 text-sm">Belum ada berita.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- Chart.js Script --}}
    @script
    <script>
        Alpine.data('chartData', () => ({
            initChart() {
                const script = document.createElement('script');
                script.src = 'https://cdn.jsdelivr.net/npm/chart.js';
                script.onload = () => {
                    const ctx = document.getElementById('financeChart').getContext('2d');
                    const data = @json($monthlyData);
                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: data.map(d => d.month),
                            datasets: [
                                {
                                    label: 'Pemasukan',
                                    data: data.map(d => d.income),
                                    backgroundColor: 'rgba(16, 185, 129, 0.7)',
                                    borderRadius: 8,
                                    borderSkipped: false,
                                },
                                {
                                    label: 'Pengeluaran',
                                    data: data.map(d => d.expense),
                                    backgroundColor: 'rgba(239, 68, 68, 0.7)',
                                    borderRadius: 8,
                                    borderSkipped: false,
                                },
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { position: 'top', labels: { usePointStyle: true, padding: 20 } },
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        callback: v => 'Rp ' + v.toLocaleString('id-ID'),
                                    },
                                    grid: { color: 'rgba(0,0,0,0.04)' }
                                },
                                x: { grid: { display: false } }
                            }
                        }
                    });
                };
                document.head.appendChild(script);
            }
        }));
    </script>
    @endscript
</div>
