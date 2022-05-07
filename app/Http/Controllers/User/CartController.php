<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Throwable;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
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
