<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chairman extends Model
{
    use HasFactory;

    protected $table = 'chairmans';

    protected $fillable = [
        'name',
        'photo',
        'birth_place',
        'birth_date',
        'period',
        'achievements',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'achievements' => 'array',
        'is_active' => 'boolean',
        'birth_date' => 'date',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->latest();
    }

    public function getFormattedBirthAttribute()
    {
        if (!$this->birth_place && !$this->birth_date) return null;
        $parts = [];
        if ($this->birth_place) $parts[] = $this->birth_place;
        if ($this->birth_date) $parts[] = $this->birth_date->translatedFormat('d F Y');
        return implode(', ', $parts);
    }
}
