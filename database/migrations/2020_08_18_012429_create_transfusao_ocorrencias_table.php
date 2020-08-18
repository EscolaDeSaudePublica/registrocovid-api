<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransfusaoOcorrenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfusao_ocorrencias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paciente_id')->references('id')->on('pacientes');
            $table->foreignId('tipo_transfusao_id')->references('id')->on('tipos_transfusao');
            $table->date('data');
            $table->float('volume_transfusao')->nullable();
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
        Schema::dropIfExists('transfusao_ocorrencias');
    }
}
