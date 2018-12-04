<?php

use Illuminate\Support\Facades\Schema;
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
            $table->increments('id');
            $table->unsignedInteger('user_id')->default(0)->index()->comment('用户 ID');
            $table->unsignedInteger('category_id')->default(0)->index()->comment('分类 ID');
            $table->string('title')->comment('标题');
            $table->text('body')->comment('内容');
            $table->unsignedInteger('reply_count')->default(0)->comment('回复数量');
            $table->unsignedInteger('view_count')->default(0)->comment('查看数量');
            $table->unsignedInteger('last_reply_user_id')->default(0)->comment('最后回复用户 ID');
            $table->integer('order')->default(0)->comment('排序');
            $table->text('excerpt')->nullable()->comment('文章摘要');
            $table->string('slug')->nullable()->comment('SEO 优化');
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
        Schema::dropIfExists('articles');
    }
}
