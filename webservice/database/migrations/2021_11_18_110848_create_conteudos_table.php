<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConteudosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conteudos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('titulo');
            $table->longText('texto');
            $table->string('imagem');
            $table->string('link');
            $table->dateTime('data');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations. php artisan migrate:rollback
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('conteudos');
    }
}
