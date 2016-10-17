<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            // 主键
            $table->increments('id');
            // 标题
            $table->string('title');
            // 简介
            $table->string('desc');
            // 内容
            $table->text('content');
            // 访问量
            $table->integer('views');
            // 软删除'deleted_at'
            $table->softDeletes();

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
        Schema::drop('articles');
    }
}
