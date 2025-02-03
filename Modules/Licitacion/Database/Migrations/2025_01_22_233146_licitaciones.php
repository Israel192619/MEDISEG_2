<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('licitaciones', function (Blueprint $table) {
            $table->increments('id');   
            $table->string('codigo_de_licitacion');
            $table->string('entidad');
            $table->string('responsable_licitacion');
            $table->string('estado');
            $table->string('ciudad');
            $table->string('telefono');
            $table->string('cuce');
            $table->string('objeto_contratacion');
            $table->string('tipo_de_proceso');
            $table->string('forma_de_adjudicacion');
            $table->date('fecha_vencimiento');
            $table->string('mes');
            $table->string('hora_de_subasta');
            $table->string('garantias_solicitadas');
            $table->string('precentacion_de_muestra');
            $table->string('direccion_de_muestra');
            $table->date('fecha_subida_proceso');
            $table->string('resultado');
            $table->string('envio_productos');
            $table->string('envio_documetacion');
            $table->string('muestras');
            $table->float('comision_de_entrega');
            $table->float('otros_gastos_de_entrega');
            $table->float('comisiones');
            $table->float('gastos_poliza');
            $table->float('solvencia_fiscal');
            $table->float('poliza');
            $table->float('precio_venta');
            $table->float('inversion');
            $table->float('gastos_opertivos');
            $table->float('impuestos');
            $table->float('gastos_administrativos');
            $table->string('comision');
            $table->float('utilidad');
            $table->date('fecha_pago');
            $table->float('monto_pago');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('licitaciones');
    }
};
