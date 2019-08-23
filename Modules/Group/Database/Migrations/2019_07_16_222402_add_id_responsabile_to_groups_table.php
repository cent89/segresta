<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIdResponsabileToGroupsTable extends Migration
{
  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::table('groups', function (Blueprint $table) {
      $table->integer('id_responsabile')->unsigned()->nullable()->after('descrizione');
      $table->foreign('id_responsabile')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('SET NULL');
    });
  }

  /**
  * Reverse the migrations.
  *
  * @return void
  */
  public function down()
  {
    Schema::table('groups', function (Blueprint $table) {

    });
  }
}
