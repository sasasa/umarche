<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('Dashboard') }}
      </h2>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-6 bg-white border-b border-gray-200">
                <x-auth-validation-errors class="mb-4" :errors="$errors" />
                <x-flash-message status="session('status')" />
                <form method="post" action="{{ route('owner.products.update', ['product' => $product]) }}">
                  @csrf
                  @method('PATCH')
                  <div class="-m-2">
                    <div class="p-2 w-1/2 mx-auto">
                      <div class="relative">
                        <label for="name" class="leading-7 text-sm text-gray-600">商品名 ※必須</label>
                        <input value="{{ old('name', $product->name) }}" required type="text" id="name" name="name" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                      </div>
                    </div>
                    <div class="p-2 w-1/2 mx-auto">
                      <div class="relative">
                        <label for="information" class="leading-7 text-sm text-gray-600">商品情報 ※必須</label>
                        <textarea rows="10" required id="information" name="information" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">{{ old('information', $product->information) }}</textarea>
                      </div>
                    </div>
                    <div class="p-2 w-1/2 mx-auto">
                      <div class="relative">
                        <label for="price" class="leading-7 text-sm text-gray-600">価格 ※必須</label>
                        <input value="{{ old('price', $product->price) }}" required type="number" id="price" name="price" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                      </div>
                    </div>
                    <div class="p-2 w-1/2 mx-auto">
                      <div class="relative">
                        <label for="sort_order" class="leading-7 text-sm text-gray-600">表示順</label>
                        <input value="{{ old('sort_order', $product->sort_order) }}" type="number" id="sort_order" name="sort_order" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                      </div>
                    </div>
                    <div class="p-2 w-1/2 mx-auto">
                      <div class="relative">
                        <label for="current_quantity" class="leading-7 text-sm text-gray-600">初期在庫 ※必須</label>
                        <input value="{{ $quantity }}" type="hidden" id="current_quantity" name="current_quantity">
                        <div class="w-full bg-gray-100 bg-opacity-50 rounded text-base outline-none py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                          {{ $quantity }}
                        </div>
                      </div>
                    </div>
                    <div class="p-2 w-1/2 mx-auto">
                      <div class="relative flex justify-around">
                        <label><input class="mr-2" type="radio" name="type" value="{{ \Constant::PRODUCT_LIST["add"] }}" @if(old('type') == \Constant::PRODUCT_LIST["add"]) checked @elseif(empty(old('type'))) checked @endif>追加</label>
                        <label><input class="mr-2" type="radio" name="type" value="{{ \Constant::PRODUCT_LIST["reduce"] }}" @if(old('type') == \Constant::PRODUCT_LIST["reduce"]) checked @endif>削減</label>
                      </div>
                    </div>
                    <div class="p-2 w-1/2 mx-auto">
                      <div class="relative">
                        <label for="quantity" class="leading-7 text-sm text-gray-600">数量 ※必須</label>
                        <input value="{{ old('quantity', 0) }}" type="text" id="quantity" name="quantity" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                        <span class="text-sm">0～99の範囲で入力してください。</span>
                      </div>
                    </div>
                    <div class="p-2 w-1/2 mx-auto">
                      <div class="relative">
                        <label for="shop_id" class="leading-7 text-sm text-gray-600">販売する店舗</label>
                        <select id="shop_id" name="shop_id" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                          @foreach($shops as $shop)
                            @if(old('shop_id'))
                              <option value="{{ $shop->id }}" @if($shop->id==old('shop_id')) selected @endif>
                                {{ $shop->name }}
                              </option>
                            @else
                              <option value="{{ $shop->id }}" @if($shop->id===$product->shop_id) selected @endif>
                                {{ $shop->name }}
                              </option>
                            @endif
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="p-2 w-1/2 mx-auto">
                      <div class="relative">
                        <label for="category" class="leading-7 text-sm text-gray-600">カテゴリー</label>
                        <select id="category" name="category" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                          @foreach($categories as $category)
                            <optgroup label="{{ $category->name }}">
                              @foreach($category->secondaries as $secondary)
                                @if(old('category'))
                                  <option value="{{ $secondary->id }}"  @if($secondary->id==old('category')) selected @endif>
                                    {{ $secondary->name }}
                                  </option>
                                @else
                                  <option value="{{ $secondary->id }}"  @if($secondary->id===$product->secondary_category_id) selected @endif>
                                    {{ $secondary->name }}
                                  </option>
                                @endif
                              @endforeach
                            </optgroup>
                          @endforeach
                        </select>
                      </div>
                    </div>
            
                    <x-select-image 
                      :images="$images"
                      currentImage="{{$product->imageFirst->filename ?? ''}}"
                      currentId="{{$product->image1}}"
                      name="image1"/>
                    <x-select-image 
                      :images="$images"
                      currentImage="{{$product->imageSecond->filename ?? ''}}"
                      currentId="{{$product->image2}}"
                      name="image2"/>
                    <x-select-image 
                      :images="$images"
                      currentImage="{{$product->imageThird->filename ?? ''}}"
                      currentId="{{$product->image3}}"
                      name="image3"/>
                    <x-select-image 
                      :images="$images"
                      currentImage="{{$product->imageFourth->filename ?? ''}}"
                      currentId="{{$product->image4}}"
                      name="image4"/>

                    <div class="p-2 w-1/2 mx-auto">
                      <div class="relative flex justify-around">
                        <label><input class="mr-2" type="radio" name="is_selling" value="1" @if(old('is_selling', $product->is_selling) == "1") checked @endif>販売中</label>
                        <label><input class="mr-2" type="radio" name="is_selling" value="0" @if(old('is_selling', $product->is_selling) == "0") checked @endif>停止中</label>
                      </div>
                    </div>
                    <div class="p-2 w-full mt-4 flex justify-around">
                      <button type="button" onclick="location.href='{{ route('owner.products.index') }}'" class="bg-gray-200 border-0 py-2 px-8 focus:outline-none hover:bg-gray-400 rounded text-lg">戻る</button>
                      <button type="submit" class="text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">更新する</button>
                    </div>
                  </div>
                </form>
                <form id="delete_{{ $product->id }}" method="POST" action="{{ route('owner.products.destroy', ['product' => $product]) }}">
                  @csrf
                  @method('DELETE')
                  <div class="p-2 w-full mt-32 flex justify-around">
                    <a onclick="deletePost(this)" data-id="{{ $product->id }}" href="#" class="text-white bg-red-400 border-0 py-2 px-4 focus:outline-none hover:bg-red-500 rounded">削除する</a>
                  </div>
                </form>
              </div>
          </div>
      </div>
  </div>
<script>
'use strict'
const images = document.querySelectorAll(".image") //全てのimageタグを取得
images.forEach(image => { // 1つずつ繰り返す
  image.addEventListener("click", function(e){ // クリックしたら
    const imageName = e.target.dataset.id.substr(0, 6) //data-idの6文字
    const imageId = e.target.dataset.id.replace(imageName + '_', "") // 6文字カット
    const imageFile = e.target.dataset.file
    const imagePath = e.target.dataset.path
    const modal = e.target.dataset.modal
    // サムネイルと input type=hiddenのvalueに設定
    document.getElementById(imageName + '_thumbnail').src = imagePath + '/' + imageFile
    document.getElementById(imageName + '_hidden').value = imageId
    MicroModal.close(modal); //モーダルを閉じる
  })
})
function deletePost(e) {
  'use strict';
  if (confirm('本当に削除してもいいですか?')) {
    document.getElementById('delete_' + e.dataset.id).submit();
  }
}
</script>
</x-app-layout>