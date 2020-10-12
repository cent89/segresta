<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFirmaGenitoriToEventsTable extends Migration
{
  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::table('events', function (Blueprint $table) {
      $table->boolean('firma_genitori')->after('email_notifica')->default(0);
    });
  }

  /**
  * Reverse the migrations.
  *
  * @return void
  */
  public function down()
  {
    Schema::table('events', function (Blueprint $table) {

    });
  }
}
