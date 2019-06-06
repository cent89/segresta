<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCfToOratoriosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('oratorios', function (Blueprint $table) {
          $table->string('cf_parrocchia')->nullable()->after('luogo_firma_moduli');
          $table->string('piva_parrocchia')->nullable()->after('luogo_firma_moduli');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
