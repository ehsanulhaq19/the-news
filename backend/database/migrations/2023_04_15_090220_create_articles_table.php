<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('title');
            $table->text('trail_text')->nullable();
            $table->text('description')->nullable();
            $table->string('url', 2048)->nullable();
            $table->timestamp('published_date')->nullable();
            $table->unsignedBigInteger('author_id');
            $table->unsignedBigInteger('source_id');
            $table->unsignedBigInteger('sub_source_id')->nullable();
            $table->unsignedBigInteger('category_id');
            $table->timestamps();
            
            //relations
            $table->foreign('author_id')->references('id')->on('article_authors');
            $table->foreign('source_id')->references('id')->on('article_sources');
            $table->foreign('sub_source_id')->references('id')->on('article_sources')->nullable();
            $table->foreign('category_id')->references('id')->on('article_categories');
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
