<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buses', function (Blueprint $table) {
            $table->id();
            $table->string('number');
            $table->unsignedBigInteger('brand_id');
            $table->unsignedBigInteger('driver_id')->nullable();

            $table->foreign('brand_id')->references('id')->on('car_brands')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('driver_id')->references('id')->on('drivers')->onDelete('cascade')->onUpdate('cascade');

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
        Schema::dropIfExists('buses');
    }
};
