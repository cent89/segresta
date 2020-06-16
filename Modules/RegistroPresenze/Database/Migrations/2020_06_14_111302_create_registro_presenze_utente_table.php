<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegistroPresenzeUtenteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registro_presenze_utente', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_registro')->unsigned();
            $table->foreign('id_registro')->references('id')->on('registro_presenze')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->integer('id_user')->unsigned();
            $table->foreign('id_user')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->boolean('presente')->default(1);
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
        Schema::dropIfExists('registro_presenze_utente');
    }
}
