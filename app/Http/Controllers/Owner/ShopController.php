<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Shop; 
use App\Http\Requests\UploadImageRequest;
use App\Services\ImageService;

class ShopController extends Controller
{
    public function __construct()
    {
        // routeに書いているのでここに書かなくてもよい
        // $this->middleware('auth:owners');
        
        $this->middleware(function($request, $next){
            $id = $request->route()->parameter('shop'); //shopのid取得
            if(!is_null($id)){ // null判定
                $shopsOwnerId = Shop::findOrFail($id)->owner->id;
                $shopId = (int)$shopsOwnerId; // キャスト 文字列→数値に型変換
                $ownerId = Auth::id();
                if($shopId !== $ownerId){ // 同じでなかったら
                    abort(404); // 404画面表示
                }
            }
            return $next($request);
        });
    }

    public function index()
    {
        
        $ownerId = Auth::id(); // 認証されているid
        $shops = Shop::where('owner_id', $ownerId)->get();
        return view('owner.shops.index', compact('shops'));
    }
    public function edit($id)
    {
        $shop = Shop::findOrFail($id);
        // dd($shop);
        return view('owner.shops.edit', compact('shop'));
    }

    public function update(UploadImageRequest $request, $id, ImageService $imageService)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'information' => 'required|string|max:1000',
            'is_selling' => 'required',
        ]);
        
        $shop = Shop::findOrFail($id);
        $shop->name = $request->name;
        $shop->information = $request->information;
        $shop->is_selling = $request->is_selling;
        $fileName = $imageService->upload($request->image, 'shops');
        if($fileName) {
            $shop->filename = $fileName;
        }
        $shop->save();

        // リサイズしない場合
        // $imageFile = $request->image; //一時保存
        // if(!is_null($imageFile) && $imageFile->isValid() ){
        //     // /storage/app/public/shopsに保存
        //     Storage::putFile('public/shops', $imageFile);
        // }
        return redirect()->
            route('owner.shops.index')->
            with([
                'message' => "店舗情報を更新しました。",
                'status' => "info",
            ]);
    }
}
