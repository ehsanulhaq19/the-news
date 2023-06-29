<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserPrefrencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_prefrences', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->jsonb('source_ids')->nullable();
            $table->jsonb('author_ids')->nullable();
            $table->jsonb('category_ids')->nullable();
            $table->timestamps();

            //relations
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_prefrences');
    }
}
