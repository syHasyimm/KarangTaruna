<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'amount',
        'description',
        'date',
        'evidence_file',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'amount' => 'integer',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeIncome($query)
    {
        return $query->whereIn('category_id', Category::where('type', 'income')->pluck('id'));
    }

    public function scopeExpense($query)
    {
        return $query->whereIn('category_id', Category::where('type', 'expense')->pluck('id'));
    }
}
