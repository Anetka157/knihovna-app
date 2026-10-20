<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Reader extends Model
{
    protected $fillable = ['name', 'email'];

    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class);
    }
}
