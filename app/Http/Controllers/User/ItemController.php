<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    public function index()
    {
        $stocks_query = Stock::select('product_id', DB::raw('sum(quantity) as sum_quantity'))
        ->groupBy('product_id')
        ->having('sum_quantity', '>', 1);

        $products = Product::with(['category','imageFirst','imageSecond','imageThird','imageFourth'])
        ->joinSub($stocks_query, 'stocks', function($join){
            $join->on('products.id', '=', 'stocks.product_id');
        })
        ->join('shops', 'products.shop_id', '=', 'shops.id')
        ->where('shops.is_selling', true)
        ->where('products.is_selling', true)->get();

        return view("user.index", compact('products'));
    }
}
