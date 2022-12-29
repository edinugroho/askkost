<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kost_id')->references('id')->on('kosts')->onDelete('cascade');
            $table->enum('parking', ['car', 'motorcycle', 'car and motorcycle']);
            $table->enum('bathroom', ['inside', 'outside']);
            $table->enum('security', ['yes', 'no']);
            $table->enum('table', ['yes', 'no']);
            $table->enum('chair', ['yes', 'no']);
            $table->enum('cupboard', ['yes', 'no']);
            $table->enum('bed', ['yes', 'no']);
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
        Schema::dropIfExists('facilities');
    }
}
