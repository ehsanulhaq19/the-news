<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
        });

        // Populate data
        DB::table('media_types')->insert(
            ['name' => 'Audio']
        );
        DB::table('media_types')->insert(
            ['name' => 'Video']
        );
        DB::table('media_types')->insert(
            ['name' => 'Image']
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('media_types');
    }
}
