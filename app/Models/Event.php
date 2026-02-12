<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['title', 'description', 'year', 'status', 'type', 'options'];

    protected $casts = [
        'options' => 'array',
    ];

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function scopeOpen($query)
    {
        return $query->where('status', 'open');
    }
}
