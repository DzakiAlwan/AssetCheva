<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    use HasFactory;

    /**
     * Relasi dengan model Product
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
