<?php

namespace App\Livewire;

use App\Models\Chairman;
use App\Models\Event;
use App\Models\Gallery;
use App\Models\GalleryCategory;
use App\Models\News;
use App\Models\Transaction;
use Livewire\Component;

class Landing extends Component
{
    public function render()
    {
        $totalIncome = Transaction::income()->sum('amount');
        $totalExpense = Transaction::expense()->sum('amount');

        return view('livewire.landing', [
            'totalIncome' => $totalIncome,
            'totalExpense' => $totalExpense,
            'balance' => $totalIncome - $totalExpense,
            'activeEvents' => Event::open()->withCount('votes')->latest()->take(3)->get(),
            'latestNews' => News::latest()->take(3)->get(),
            'galleries' => Gallery::active()->with('category')->ordered()->take(12)->get(),
            'galleryCategories' => GalleryCategory::withCount('activeGalleries')->ordered()->get(),
            'activeChairman' => Chairman::active()->ordered()->first(),
        ])->layout('layouts::landing');
    }
}
