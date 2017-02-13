<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('places', function (Blueprint $table) {
            $table->increments('id');
            $table->string('object_id')->unique();
            $table->string('name');
            $table->string('type');
            $table->string('value')->nullable()->default(null);
            $table->decimal('longitude', 14, 10)->nullable()->default(null);
            $table->decimal('latitude', 14, 10)->nullable()->default(null);
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
        Schema::dropIfExists('places');
    }
}
