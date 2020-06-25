<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTravelclaimmileageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travelclaimmileage', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('travelclaim');
            $table->integer('mileagetype');
            $table->string('origin');
            $table->string('destination');
            $table->text('reason');
            $table->date('journeydate');
            $table->time('journeytime');
            $table->double('mileage');
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
        Schema::dropIfExists('travelclaimmileage');
    }
}
