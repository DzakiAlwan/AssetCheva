<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id',
        'borrower_name',
        'quantity',
        'borrow_date',
        'return_date',
        'class',
        'phone_number'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'borrow_date' => 'date',
        'return_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the product associated with the borrowing.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
