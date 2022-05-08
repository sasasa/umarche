<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\User;
use App\Models\Stock;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Throwable;
use Illuminate\Support\Facades\Log;
use App\Constants\Common as Constant;
use App\Services\CartService;
use App\Jobs\SendThanksMail;
use App\Jobs\SendOrderedMail;

class CartController extends Controller
{
    public function cancel(Request $request){
        foreach(Auth::user()->products as $product) {
            Stock::create([
                'product_id' => $product->id,
                'type' => Constant::PRODUCT_LIST['add'],
                'quantity' => $product->pivot->quantity
            ]);
        }
        return redirect()->
            route("user.cart.index")->
            with([
                'message' => "購入をキャンセルしました。",
                'status' => "info",
            ]);;
        
    }
    public function success(Request $request)
    {
        $items = Cart::where("user_id", Auth::id())->get();
        // dd($items);
        $products = CartService::getItemsInCart($items);
        SendThanksMail::dispatch(Auth::user(), $products);
        foreach($products as $product) {
            SendOrderedMail::dispatch($product, Auth::user());
        }
        
        Cart::where("user_id", Auth::id())->delete();
        return redirect()->
            route("user.items.index")->
            with([
                'message' => "ありがとうございました。購入しました。",
                'status' => "info",
            ]);;
    }
    public function checkout(Request $request)
    {
        $user = Auth::user();
        $products = $user->products;
        $lineItems = [];
        foreach($products as $product) {
            $quantity = null;
            $quantity = Stock::where('product_id', $product->id)->sum('quantity');
            if($product->pivot->quantity > $quantity) {
                return redirect()->
                    route('user.cart.index')->
                    with([
                        'message' => "在庫が足りません。",
                        'status' => "info",
                    ]);
            }
            $lineItem = [
                'name' => $product->name,
                'description' => $product->information,
                'amount' => $product->price,
                'currency' => 'jpy',
                'quantity' => $product->pivot->quantity,
            ];
            $lineItems[] = $lineItem;
        }
        foreach($products as $product) {
            Stock::create([
                'product_id' => $product->id,
                'type' => Constant::PRODUCT_LIST["reduce"],
                "quantity" => $product->pivot->quantity * -1,
            ]);
        }
        // dd('test');
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [$lineItems],
            "mode" => "payment",
            'success_url' => route("user.cart.success"),
            'cancel_url' => route("user.cart.cancel"),
        ]);
        $publicKey = env('STRIPE_PUBLIC_KEY');
        return view('user.checkout', compact('session', 'publicKey'));
    }
    
    public function add(Request $request)
    {
        $itemInCart = Cart::where('product_id', $request->product_id)->where('user_id', Auth::id())->first();
        if($itemInCart) {
            $itemInCart->quantity += $request->quantity;
            $itemInCart->save();
        } else {
            Cart::create([
                'product_id' => $request->product_id,
                'user_id' => Auth::id(),
                'quantity' => $request->quantity ,
            ]);
        }
        return redirect()->route('user.cart.index');
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $products = $user->products;
        $totalPrice = 0;
        foreach($products as $product) {
            $totalPrice += $product->price * $product->pivot->quantity;
        }
        // dd($products, $totalPrice);
        return view('user.cart', compact('products', 'totalPrice'));
    }

    public function delete(Request $request, int $id)
    {
        Cart::where("product_id", $id)->where("user_id", Auth::id())->delete();
        return redirect()->route("user.cart.index");
    }
}
