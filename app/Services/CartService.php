<?php
namespace App\Services;
use App\Models\Product;
use App\Models\Cart;
use App\Models\ProductForMail;
use Illuminate\Database\Eloquent\Collection;


class CartService
{
    public static function getItemsInCart(Collection $items)
    {
        $productList = [];
        foreach($items as $item){
            $productForMail = new ProductForMail();
            $p = Product::findOrFail($item->product_id);
            $owner = $p->shop->owner->select('name', 'email')->first()->toArray();//オーナー情報
            $values = array_values($owner); //連想配列の値を取得
            $keys = ['ownerName', 'email'];
            $ownerInfo = array_combine($keys, $values); // オーナー情報のキーを変更
            $products = Product::where('id', $item->product_id)->select('id', 'name', 'price')->get()->toArray(); // 商品情報の配列
            $quantity_all_cart = Cart::where('product_id', $item->product_id)->sum('quantity'); // 現在カート内に入っている個数の配列
            $quantity_all_cart = ['quantity_in_cart' => $quantity_all_cart];
            $quantity = Cart::where('product_id', $item->product_id)->where('user_id', $item->user_id)->select('quantity')->get()->toArray(); // 買われた個数の配列
            $result = array_merge($products[0], $ownerInfo, $quantity_all_cart, $quantity[0]); // 配列の結合
            $productForMail->id = $result['id'];
            $productForMail->name = $result['name'];
            $productForMail->price = $result['price'];
            $productForMail->ownerName = $result['ownerName'];
            $productForMail->email = $result['email'];
            $productForMail->quantity = $result['quantity'];
            $productForMail->quantity_in_cart = $result['quantity_in_cart'];
            // dd($productForMail);
            $productList[] = $productForMail;
        }
        return $productList;
    }
}