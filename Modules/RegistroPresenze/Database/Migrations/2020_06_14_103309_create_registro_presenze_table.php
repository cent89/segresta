<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegistroPresenzeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registro_presenze', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->integer('id_oratorio')->unsigned();
          $table->foreign('id_oratorio')->references('id')->on('oratorios')->onUpdate('RESTRICT')->onDelete('CASCADE');
          $table->integer('id_event')->unsigned();
          $table->foreign('id_event')->references('id')->on('events')->onUpdate('RESTRICT')->onDelete('CASCADE');
          $table->string('titolo');
          $table->date('data');
          $table->boolean('aperto')->default(1);
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
        Schema::dropIfExists('registro_presenze');
    }
}
