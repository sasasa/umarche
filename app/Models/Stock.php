<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_id',
        "type",
        "quantity",
    ];

    protected $table = "t_stocks";

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
}
