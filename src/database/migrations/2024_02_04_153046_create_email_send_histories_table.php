<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailSendHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_send_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('send_user_id')->nullable()->comment('送信ユーザーID');
            $table->unsignedBigInteger('send_shop_id')->nullable()->comment('送信店舗ID');
            $table->unsignedBigInteger('email_template_id')->nullable()->comment('メールテンプレートID');
            $table->timestamp('sent_datetime')->comment('送信日時');
            $table->tinyInteger('success_flag')->comment('送信成功フラグ(0:失敗,1:成功)');
            $table->text('error_message')->nullable()->comment('エラーメッセージ');
            $table->string('user_type', 10)->comment('ユーザー区分(1:管理者、2:店舗代表者)');
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
        Schema::dropIfExists('email_send_histories');
    }
}
