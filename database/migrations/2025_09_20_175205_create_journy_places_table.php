<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJournyPlacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('journy_places', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bus_route_id')->index();
            $table->unsignedBigInteger('pickupdrop_id')->index();
            $table->time('time');
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->foreign('bus_route_id')->references('id')->on('bus_routes')->onDelete('cascade');
            $table->foreign('pickupdrop_id')
                ->references('id')
                ->on('pickup_drops')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('journy_places');
    }
}
