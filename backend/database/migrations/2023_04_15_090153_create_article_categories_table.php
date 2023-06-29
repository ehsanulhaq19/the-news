<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateArticleCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
        });

        // Populate data
        DB::table('article_categories')->insert(
            ['name' => 'Business']
        );
        DB::table('article_categories')->insert(
            ['name' => 'Politics']
        );
        DB::table('article_categories')->insert(
            ['name' => 'Sport']
        );
        DB::table('article_categories')->insert(
            ['name' => 'World']
        );
        DB::table('article_categories')->insert(
            ['name' => 'Entertainment']
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('article_categories');
    }
}
