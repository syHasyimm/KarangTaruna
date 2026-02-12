<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function finance(Request $request)
    {
        $month = $request->get('month', now()->month);
        $year = $request->get('year', now()->year);

        $transactions = Transaction::with(['category', 'user'])
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->orderBy('date')
            ->get();

        $totalIncome = $transactions->filter(fn($t) => $t->category->type === 'income')->sum('amount');
        $totalExpense = $transactions->filter(fn($t) => $t->category->type === 'expense')->sum('amount');
        $balance = $totalIncome - $totalExpense;

        $pdf = Pdf::loadView('reports.finance', [
            'transactions' => $transactions,
            'totalIncome' => $totalIncome,
            'totalExpense' => $totalExpense,
            'balance' => $balance,
            'month' => $month,
            'year' => $year,
        ]);

        $filename = "Laporan_Keuangan_{$month}_{$year}.pdf";
        return $pdf->download($filename);
    }
}
