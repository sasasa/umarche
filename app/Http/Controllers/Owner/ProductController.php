<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Image;
use App\Models\SecondaryCategory;
use App\Models\PrimaryCategory;
use App\Models\Shop;
use App\Models\Owner;
use App\Models\Stock;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Throwable;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\ProductRequest;
use App\Constants\Common as Constant;

class ProductController extends Controller
{
    public function __construct()
    {
        // routeに書いているのでここに書かなくてもよい
        // $this->middleware('auth:owners');
        
        $this->middleware(function($request, $next){
            $productId = $request->route()->parameter('product');
            if(!is_null($productId)){
                $productOwnerId = Product::findOrFail($productId)->shop->owner->id;
                $ownerId = (int)$productOwnerId;
                if($ownerId !== Auth::id()){
                    abort(404);
                }
            }
            return $next($request);
        });
    }

    public function index()
    {
        // $products = Owner::findOrFail(Auth::id())->shop->products;
        $ownerInfo = Owner::with("shop.products.imageFirst")->where("id", Auth::id())->first();
        return view('owner.products.index', compact('ownerInfo'));
    }


    public function create()
    {
        $shops = Shop::where('owner_id', Auth::id())->
            select('id', 'name')->get();
        $images = Image::where('owner_id', Auth::id())->
            select('id', 'title', 'filename')->orderBy('updated_at', 'desc')->get();
        $categories = PrimaryCategory::with('secondaries')->get();
        
        return view('owner.products.create', compact('shops', 'images', 'categories'));
    }


    public function store(ProductRequest $request)
    {
        try {
            DB::transaction(function() use ($request){
                $product = Product::create([
                    'name' => $request->name,
                    'information' => $request->information,
                    "price" => $request->price,
                    "sort_order" => $request->sort_order,
                    'shop_id' => $request->shop_id,
                    'secondary_category_id' => $request->category,
                    'image1' => $request->image1,
                    'image2' => $request->image2,
                    'image3' => $request->image3,
                    'image4' => $request->image4,
                    'is_selling' => $request->is_selling,
                ]);
                Stock::create([
                    'product_id' => $product->id,
                    'type' => 1,
                    "quantity" => $request->quantity,
                ]);
            }, 2);
        } catch(Throwable $e) {
            Log::error($e);
            throw $e;
        }

        return redirect()
            ->route('owner.products.index')
            ->with([
                'message' => '商品登録しました。',
                'status' => "info",
            ]);
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $quantity = Stock::where('product_id', $product->id)->sum("quantity");
        $shops = Shop::where('owner_id', Auth::id())->
            select('id', 'name')->get();
        $images = Image::where('owner_id', Auth::id())->
            select('id', 'title', 'filename')->orderBy('updated_at', 'desc')->get();
        $categories = PrimaryCategory::with('secondaries')->get();
        return view('owner.products.edit', compact('product', 'quantity', 'shops', 'images', 'categories'));
    }


    public function update(ProductRequest $request, $id)
    {
        $request->validate([
            'current_quantity' => 'required|integer',
        ]);
        $product = Product::findOrFail($id);
        $quantity = Stock::where('product_id', $product->id)->sum("quantity");
        if($request->current_quantity !== $quantity) {
            // 楽観ロック、現在値と送られてきた値が異なるときはいったん戻す。
            // $id = $request->route()->parameter('product');
            return redirect()->
                route('owner.products.edit', ['product' => $id])->
                with([
                    'message' => '在庫数が変更されています再度確認してください。',
                    'status' => "alert",
                ]);;
        }
        try {
            DB::transaction(function() use ($request, $product){
                
                $product->name = $request->name;
                $product->information = $request->information;
                $product->price = $request->price;
                $product->sort_order = $request->sort_order;
                $product->shop_id = $request->shop_id;
                $product->secondary_category_id = $request->category;
                $product->image1 = $request->image1;
                $product->image2 = $request->image2;
                $product->image3 = $request->image3;
                $product->image4 = $request->image4;
                $product->is_selling = $request->is_selling;
                $product->save();
                if($request->type === Constant::PRODUCT_LIST["add"]){
                    $newQuantity = $request->quantity; 
                } elseif($request->type === Constant::PRODUCT_LIST["reduce"]){
                    $newQuantity = $request->quantity * -1;
                }
                Stock::create([
                    'product_id' => $product->id,
                    'quantity' => $newQuantity,
                    'type' => $request->type,
                ]);
            }, 2);
        } catch(Throwable $e) {
            Log::error($e);
            throw $e;
        }
        return redirect()
            ->route('owner.products.index')
            ->with([
                'message' => '商品情報を更新しました。',
                'status' => "info",
            ]);
    }

    public function destroy($id)
    {
        Product::findOrFail($id)->delete();

        return redirect()->
            route('owner.products.index')->
            with([
                'message' => "商品を削除しました。",
                'status' => "alert",
            ]);
    }
}
