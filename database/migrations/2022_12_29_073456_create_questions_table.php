<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kost_id')->references('id')->on('kosts')->onDelete('cascade');
            $table->foreignId('owner_id')->references('id')->on('owners')->onDelete('cascade');
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->enum('status', ['asked', 'answered']);
            $table->enum('available', ['yes', 'no'])->default(null);
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
        Schema::dropIfExists('questions');
    }
}
