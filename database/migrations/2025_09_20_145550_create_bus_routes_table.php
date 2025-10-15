<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusRoutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bus_routes', function (Blueprint $table) {
            $table->id();
            // $table->unsignedBigInteger('buses_id')->unsigned()->index();
            $table->string('route_name');
            $table->string('slug');
            $table->string('from_id')->nullable();
            $table->string('departure_time')->nullable();
            $table->string('to_id')->nullable();
            $table->string('arrival_time')->nullable();
            $table->string('total_duration')->nullable();
            $table->string('total_seat')->nullable();
            $table->string('price')->nullable();
            $table->string('run')->nullable();
            $table->string('run_optionals')->nullable();
            $table->boolean('is_active')->default(1);
            $table->timestamps();

            // $table->foreign('buses_id')->references('id')->on('buses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bus_routes');
    }
}
