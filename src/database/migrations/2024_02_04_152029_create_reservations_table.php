<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->comment('ユーザーID');
            $table->unsignedBigInteger('shop_id')->comment('店舗ID');
            $table->date('reservation_date')->comment('予約日');
            $table->time('reservation_time')->comment('予約時間');
            $table->integer('party_size')->comment('予約人数');
            $table->string('status', 10)->comment('予約ステータス(1:予約済,2:来店済,3,:決済完了,4:評価済,99:キャンセル)');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('shop_id')->references('id')->on('shops');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservations');
    }
}
