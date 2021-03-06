<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Stock;
use App\Models\PrimaryCategory;
use Illuminate\Support\Facades\DB;
use App\Jobs\SendThanksMail;
use App\Enums\SortOrder;
class ItemController extends Controller
{
    public function __construct()
    {
        // routeに書いているのでここに書かなくてもよい
        // $this->middleware('auth:users');
        
        $this->middleware(function($request, $next){
            $productId = $request->route()->parameter('item');
            if(!is_null($productId)){
                $isExist = Product::availableItems()->where('products.id', $productId)->exists();
                if(!$isExist) {
                    abort(404);
                }
            }
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        // dd($request);
        // SendThanksMail::dispatch();

        $products = Product::availableItems()->
            selectCategory($request->category ?? '0')->
            searchKeyword($request->keyword)->
            sortOrder($request->sort)->
            paginate($request->pagination ?? 20);
        $categories = PrimaryCategory::with('secondaries')->get();
        $orders = SortOrder::cases();
        return view("user.index", compact('products', 'categories', 'orders'));
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
