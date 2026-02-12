<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Keuangan</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 3px solid #16a34a; padding-bottom: 15px; }
        .header h1 { font-size: 22px; color: #15803d; margin: 0; }
        .header p { color: #666; margin: 5px 0 0; }
        .summary { display: flex; margin-bottom: 20px; }
        .summary-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .summary-table td { padding: 8px 12px; }
        .summary-table .label { color: #666; width: 150px; }
        .summary-table .value { font-weight: bold; font-size: 14px; }
        .income { color: #16a34a; }
        .expense { color: #dc2626; }
        table.transactions { width: 100%; border-collapse: collapse; }
        table.transactions th { background: #f0fdf4; color: #15803d; padding: 10px 8px; text-align: left; border-bottom: 2px solid #16a34a; font-size: 11px; text-transform: uppercase; }
        table.transactions td { padding: 8px; border-bottom: 1px solid #e5e7eb; }
        table.transactions tr:nth-child(even) { background: #fafafa; }
        .text-right { text-align: right; }
        .footer { margin-top: 30px; text-align: center; font-size: 10px; color: #999; border-top: 1px solid #e5e7eb; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Karang Taruna</h1>
        <p>Laporan Keuangan - Bulan {{ $month }}/{{ $year }}</p>
    </div>

    <table class="summary-table">
        <tr>
            <td class="label">Total Pemasukan:</td>
            <td class="value income">Rp {{ number_format($totalIncome, 0, ',', '.') }}</td>
            <td class="label">Total Pengeluaran:</td>
            <td class="value expense">Rp {{ number_format($totalExpense, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="label">Saldo:</td>
            <td class="value" colspan="3">Rp {{ number_format($balance, 0, ',', '.') }}</td>
        </tr>
    </table>

    <table class="transactions">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Kategori</th>
                <th>Keterangan</th>
                <th>Tipe</th>
                <th class="text-right">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $i => $trx)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $trx->date->format('d/m/Y') }}</td>
                <td>{{ $trx->category->name }}</td>
                <td>{{ $trx->description ?? '-' }}</td>
                <td>
                    <span class="{{ $trx->category->type === 'income' ? 'income' : 'expense' }}">
                        {{ $trx->category->type === 'income' ? 'Masuk' : 'Keluar' }}
                    </span>
                </td>
                <td class="text-right {{ $trx->category->type === 'income' ? 'income' : 'expense' }}">
                    Rp {{ number_format($trx->amount, 0, ',', '.') }}
                </td>
            </tr>
            @empty
            <tr><td colspan="6" style="text-align:center; padding: 20px; color: #999;">Tidak ada transaksi pada periode ini.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak pada {{ now()->format('d/m/Y H:i') }} - Sistem KarangTaruna</p>
    </div>
</body>
</html>
