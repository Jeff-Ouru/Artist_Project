<?php

namespace App\Models;

use Database\Factories\SaleFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    /** @use HasFactory<SaleFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'product_name',
        'quantity',
        'price',
        'sale_date',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'total_unit_price' => 'decimal:2',
        'sale_date' => 'datetime',
    ];
}