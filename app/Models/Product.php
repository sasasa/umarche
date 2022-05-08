<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Shop;
use App\Models\SecondaryCategory;
use App\Models\Image;
use App\Models\User;
use App\Models\Stock;
use Illuminate\Support\Facades\DB;
use App\Constants\Common as Constant;
class Product extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'shop_id',
        'name',
        'information',
        "price",
        'is_selling',
        "sort_order",
        'secondary_category_id',
        'image1',
        'image2',
        'image3',
        'image4',
    ];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
    public function category(){
        return $this->belongsTo(SecondaryCategory::class, 'secondary_category_id');
    }
    public function imageFirst(){
        return $this->belongsTo(Image::class, 'image1', 'id');
    }
    public function imageSecond(){
        return $this->belongsTo(Image::class, 'image2', 'id');
    }
    public function imageThird(){
        return $this->belongsTo(Image::class, 'image3', 'id');
    }
    public function imageFourth(){
        return $this->belongsTo(Image::class, 'image4', 'id');
    }
    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'carts')->withPivot(['id', 'quantity']);
    }

    public function scopeAvailableItems($query)
    {
        $stocks_subquery = Stock::select('product_id', DB::raw('sum(quantity) as sum_quantity'))
        ->groupBy('product_id')
        ->having('sum_quantity', '>', 1);

        $products_query = $query->with(['category','imageFirst',])
        ->joinSub($stocks_subquery, 'stocks', function($join){
            $join->on('products.id', '=', 'stocks.product_id');
        })
        ->join('shops', 'products.shop_id', '=', 'shops.id')
        ->where('shops.is_selling', true)
        ->where('products.is_selling', true)
        ->select('products.id as id', 'products.name as name', 'products.price', 'products.secondary_category_id',
                'products.sort_order as sort_order','products.information', 'products.image1');
        return $products_query;
    }

    public function scopeSortOrder($query, $sortOrder){
        if($sortOrder === null || $sortOrder === Constant::SORT_ORDER['recommend']){
            return $query->orderBy('sort_order', 'asc');
        }
        if($sortOrder === Constant::SORT_ORDER['higherPrice']){
            return $query->orderBy('price', 'desc');
        }
        if($sortOrder === Constant::SORT_ORDER['lowerPrice']){
            return $query->orderBy('price', 'asc');
        }
        if($sortOrder === Constant::SORT_ORDER['later']){
            return $query->orderBy('products.created_at', 'desc');
        }
        if($sortOrder === Constant::SORT_ORDER['older']){
            return $query->orderBy('products.created_at', 'asc');
        }
    }

    public function scopeSelectCategory($query, $categoryId)
    {
        if($categoryId !== '0') {
            return $query->where('secondary_category_id', $categoryId);
        } else {
            return $query;
        }
    }
}
