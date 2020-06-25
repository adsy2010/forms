<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTravelclaimTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travelclaim', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user');
            $table->double('subsistence')->default('0.00');
            $table->double('transport')->default('0.00');
            $table->double('parking')->default('0.00');
            $table->integer('status')->default('0');
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
        Schema::dropIfExists('travelclaim');
    }
}
