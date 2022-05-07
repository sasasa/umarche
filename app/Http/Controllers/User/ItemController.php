<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    public function __construct()
    {
        // routeに書いているのでここに書かなくてもよい
        // $this->middleware('auth:users');
    }

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
        ->where('products.is_selling', true)
        ->select('products.id as id', 'products.name as name', 'products.price', 'products.secondary_category_id',
                'products.sort_order as sort_order','products.information', 'products.image1')
        ->get();

        return view("user.index", compact('products'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        $quantity = Stock::where('product_id', $product->id)->sum('quantity');
        if($quantity > 9){
            $quantity = 9;
        } 
        return view('user.show', compact('product', 'quantity'));
    }
}
