<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    public function up()
    {
        Schema::create('favorites', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index();
            $table->integer('task_id')->unsigned()->index();
            $table->timestamps();

            // 外部キー設定
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade');

            // user_idとtask_idの重複を許さない → 同じtaskを何回もお気に入り登録できなくする
            $table->unique(['user_id', 'task_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('favorites');
    }
}
