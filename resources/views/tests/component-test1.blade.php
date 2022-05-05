<x-tests.app>
  <x-slot name="header">
    ヘッダー１
  </x-slot>
  コンポーネントテスト1
  <x-tests.card title="タイトル1" content="コンテント1" :message="$message" />
  <x-tests.card title="タイトル1-1" />
  <x-tests.card title="タイトル1-2" class="bg-red-300" />
  <x-test-class-base classBaseMessage="クラスベースメッセージ1" />
  
</x-tests.app>