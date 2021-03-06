<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPluralSitioTiposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('sitio_tipo', 'sitios_tipos');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exames_rt_pcr', function (Blueprint $table) {
            $table->dropForeign(['sitio_tipo_id']);
        });
        Schema::dropIfExists('sitios_tipos');
    }
}
