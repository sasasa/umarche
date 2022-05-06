<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            // cascadeあり
            $table->foreignId('shop_id')->
                constrained()->
                onUpdate('cascade')->
                onDelete('cascade');
            // cascadeなし
            $table->foreignId('secondary_category_id')->constrained();
            // カラム名から推測できないのでテーブル名を渡す
            $table->foreignId('image1')->nullable()->constrained('images');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
