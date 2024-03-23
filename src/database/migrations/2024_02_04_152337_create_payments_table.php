<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reservation_id')->comment('予約ID');
            $table->dateTime('payment_date')->comment('支払い日時');
            $table->integer('amount')->comment('支払い金額');
            $table->string('payment_method', 10)->comment('支払い方法(1:クレジット決済,2:現金,99:その他)');
            $table->string('payment_status', 10)->comment('支払いステータス(0:支払い未,1:支払い済,2:決済エラー)');
            $table->timestamps();

            $table->foreign('reservation_id')->references('id')->on('reservations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
