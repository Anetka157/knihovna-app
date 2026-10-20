<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Loan extends Model
{
    protected $fillable = ['book_id', 'reader_id', 'borrowed_at', 'due_at', 'returned_at'];

    protected $casts = [
        'borrowed_at' => 'datetime',
        'due_at' => 'datetime',
        'returned_at' => 'datetime',
    ];

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function reader(): BelongsTo
    {
        return $this->belongsTo(Reader::class);
    }

    // Scope pro snadné načtení výpůjček po termínu
    public function scopeOverdue($query)
    {
        return $query->whereNull('returned_at')
            ->where('due_at', '<', now());
    }
}
