<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExtraclasealumnosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('extraclase_alumnos', function (Blueprint $table) {
           $table->unsignedInteger('id');
            $table->foreign('id')->references('id')->on('extraclases')->onDelete('cascade');
            $table->unsignedInteger('idalumno');
            $table->foreign('idalumno')->references('id')->on('personas')->onDelete('cascade');
            $table->boolean('estado');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('extraclase_alumnos');
    }
}
