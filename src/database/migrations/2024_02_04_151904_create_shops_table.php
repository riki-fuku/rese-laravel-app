<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->comment('店舗名');
            $table->unsignedBigInteger('area_id')->comment('エリアID');
            $table->unsignedBigInteger('genre_id')->comment('ジャンルID');
            $table->text('description')->comment('店舗概要');
            $table->time('opening_time')->comment('営業開始時間');
            $table->time('closing_time')->comment('営業終了時間');
            $table->text('image_url')->comment('店舗画像URL');
            $table->timestamps();

            $table->foreign('area_id')->references('id')->on('areas');
            $table->foreign('genre_id')->references('id')->on('genres');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shops');
    }
}
