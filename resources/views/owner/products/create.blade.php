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
                <form method="post" action="{{ route('owner.products.store') }}">
                  @csrf
                  <div class="-m-2">
                    <div class="p-2 w-1/2 mx-auto">
                      <div class="relative">
                        <label for="name" class="leading-7 text-sm text-gray-600">商品名 ※必須</label>
                        <input value="{{ old('name') }}" required type="text" id="name" name="name" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                      </div>
                    </div>
                    <div class="p-2 w-1/2 mx-auto">
                      <div class="relative">
                        <label for="information" class="leading-7 text-sm text-gray-600">商品情報 ※必須</label>
                        <textarea rows="10" required id="information" name="information" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">{{ old('information') }}</textarea>
                      </div>
                    </div>
                    <div class="p-2 w-1/2 mx-auto">
                      <div class="relative">
                        <label for="price" class="leading-7 text-sm text-gray-600">価格 ※必須</label>
                        <input value="{{ old('price') }}" required type="number" id="price" name="price" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                      </div>
                    </div>
                    <div class="p-2 w-1/2 mx-auto">
                      <div class="relative">
                        <label for="sort_order" class="leading-7 text-sm text-gray-600">表示順</label>
                        <input value="{{ old('sort_order') }}" type="number" id="sort_order" name="sort_order" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                      </div>
                    </div>
                    <div class="p-2 w-1/2 mx-auto">
                      <div class="relative">
                        <label for="quantity" class="leading-7 text-sm text-gray-600">初期在庫 ※必須</label>
                        <input value="{{ old('quantity') }}" required type="number" id="quantity" name="quantity" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                        <span class="text-sm">0～99の範囲で入力してください。</span>
                      </div>
                    </div>
                    <div class="p-2 w-1/2 mx-auto">
                      <div class="relative">
                        <label for="shop_id" class="leading-7 text-sm text-gray-600">販売する店舗</label>
                        <select id="shop_id" name="shop_id" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                          @foreach($shops as $shop)
                            <option value="{{ $shop->id}}">{{ $shop->name }}</option>
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
                                <option value="{{ $secondary->id}}">{{ $secondary->name }}</option>
                              @endforeach
                            </optgroup>
                          @endforeach
                        </select>
                      </div>
                    </div>
            
                    <x-select-image :images="$images" name="image1" />
                    <x-select-image :images="$images" name="image2" />
                    <x-select-image :images="$images" name="image3" />
                    <x-select-image :images="$images" name="image4" />
                    <x-select-image :images="$images" name="image5" />

                    <div class="p-2 w-1/2 mx-auto">
                      <div class="relative flex justify-around">
                        <label><input class="mr-2" type="radio" name="is_selling" value="1" @if(old('is_selling') == "1") checked @endif>販売中</label>
                        <label><input class="mr-2" type="radio" name="is_selling" value="0" @if(old('is_selling') == "0") checked @endif>停止中</label>
                      </div>
                    </div>
                    <div class="p-2 w-full mt-4 flex justify-around">
                      <button type="button" onclick="location.href='{{ route('owner.products.index') }}'" class="bg-gray-200 border-0 py-2 px-8 focus:outline-none hover:bg-gray-400 rounded text-lg">戻る</button>
                      <button type="submit" class="text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">登録する</button>
                    </div>
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
</script>
</x-app-layout>