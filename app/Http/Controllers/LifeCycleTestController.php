<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LifeCycleTestController extends Controller
{
    public function showServiceProvider()
    {
        $encrypt = app()->make('encrypter');
        $pass = $encrypt->encrypt('password');
        $serviceProviderTest = app()->make('serviceProviderTest');
        dd($pass, $encrypt->decrypt($pass), $serviceProviderTest);
    }
    
    public function showServiceContainer()
    {
        app()->bind('lifeCycleTest', function(){
            return 'ライフサイクルテスト';
        });
        $test = app()->make('lifeCycleTest');

        // サービスコンテナ無しのパターン
        // $message = new Message();
        // $sample = new Sample($message);
        // $sample->run();

        // サービスコンテナありのパターン
        app()->bind('sample', Sample::class);
        $sample = app()->make('sample');
        $sample->run();
        dd($test, app());
    }
}
class Message
{
    public function send(){
        echo('メッセージ表示');
    }
}
class Sample
{
    public $message;
    public function __construct(Message $message){
        $this->message = $message;
    }
    public function run(){
        $this->message->send();
    }
}