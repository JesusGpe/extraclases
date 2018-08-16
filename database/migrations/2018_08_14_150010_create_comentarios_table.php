<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComentariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comentarios', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('idpersona');
            $table->foreign('idpersona')->references('id')->on('personas')->onDelete('cascade');
            $table->unsignedInteger('idpublicacion');
            $table->foreign('idpublicacion')->references('id')->on('publicaciones')->onDelete('cascade');
            $table->string('comentario',512);
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
        Schema::dropIfExists('comentarios');
    }
}
