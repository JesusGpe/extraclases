<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePublicacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publicaciones', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('idextraclase');
            $table->foreign('idextraclase')->references('id')->on('extraclases')->onDelete('cascade');
            $table->unsignedInteger('idpersona');
            $table->foreign('idpersona')->references('id')->on('personas')->onDelete('cascade');
            $table->string('publicacion',512);
            $table->string('imagen',100)->nullable();
            $table->boolean('estado');
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
        Schema::dropIfExists('publicaciones');
    }
}
