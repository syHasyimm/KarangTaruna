<?php

namespace App\Livewire\Dashboard;

use App\Models\Transaction;
use App\Models\Event;
use App\Models\News;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $totalIncome = Transaction::income()->sum('amount');
        $totalExpense = Transaction::expense()->sum('amount');
        $balance = $totalIncome - $totalExpense;

        $recentTransactions = Transaction::with(['category', 'user'])
            ->latest('date')
            ->take(5)
            ->get();

        $activeEvents = Event::open()->withCount('votes')->latest()->take(3)->get();
        $latestNews = News::latest()->take(3)->get();

        // Monthly data for chart — 2 queries instead of 12
        $sixMonthsAgo = now()->subMonths(5)->startOfMonth();

        $incomeByMonth = Transaction::income()
            ->where('date', '>=', $sixMonthsAgo)
            ->selectRaw("DATE_FORMAT(date, '%Y-%m') as ym, SUM(amount) as total")
            ->groupBy('ym')
            ->pluck('total', 'ym');

        $expenseByMonth = Transaction::expense()
            ->where('date', '>=', $sixMonthsAgo)
            ->selectRaw("DATE_FORMAT(date, '%Y-%m') as ym, SUM(amount) as total")
            ->groupBy('ym')
            ->pluck('total', 'ym');

        $monthlyData = collect();
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $key = $date->format('Y-m');
            $monthlyData->push([
                'month' => $date->translatedFormat('M Y'),
                'income' => $incomeByMonth[$key] ?? 0,
                'expense' => $expenseByMonth[$key] ?? 0,
            ]);
        }

        return view('livewire.dashboard.index', [
            'totalIncome' => $totalIncome,
            'totalExpense' => $totalExpense,
            'balance' => $balance,
            'recentTransactions' => $recentTransactions,
            'activeEvents' => $activeEvents,
            'latestNews' => $latestNews,
            'monthlyData' => $monthlyData,
        ]);
    }
}
