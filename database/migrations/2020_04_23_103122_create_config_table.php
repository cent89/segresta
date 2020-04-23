<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigTable extends Migration
{
  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::create('config', function (Blueprint $table) {
      $table->string('key')->unique();
      $table->string('config');
      $table->string('display_name')->nullable(true);
      $table->string('value')->nullable(true);
      $table->string('group')->nullable(true);
      $table->string('type')->nullable(true)->default('text');
      $table->integer('order')->default(0);
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
    Schema::dropIfExists('config');
  }
}
