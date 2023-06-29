<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticleSourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_sources', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->boolean('is_parent_source')->default(0);
            $table->timestamps();
        });

        // Populate data
        DB::table('article_sources')->insert(
            ['name' => 'News.org', 'is_parent_source' => true]
        );
        DB::table('article_sources')->insert(
            ['name' => 'The Guardian', 'is_parent_source' => true]
        );
        DB::table('article_sources')->insert(
            ['name' => 'New York Times', 'is_parent_source' => true]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('article_sources');
    }
}
