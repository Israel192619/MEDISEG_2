<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
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
            $table->text('objeto_contratacion')->nullable();
            $table->string('tipo_de_proceso')->nullable();
            $table->string('forma_de_adjudicacion')->nullable();
            $table->date('fecha_vencimiento')->nullable();
            $table->string('mes')->nullable();
            $table->string('hora_de_subasta')->nullable();
            $table->string('garantias_solicitadas')->nullable();
            $table->string('presentacion_de_muestra')->nullable();
            $table->string('direccion_de_muestra')->nullable();
            $table->date('fecha_subida_proceso')->nullable();
            $table->string('resultado')->nullable();
            $table->float('envio_productos')->nullable();
            $table->float('envio_documentacion')->nullable();
            $table->float('muestras')->nullable();
            $table->float('comision_de_entrega')->nullable();
            $table->float('otros_gastos_de_entrega')->nullable();
            $table->float('comisiones')->nullable();
            $table->float('gastos_poliza')->nullable();
            $table->float('solvencia_fiscal')->nullable();
            $table->float('poliza')->nullable();
            $table->float('precio_venta')->nullable();
            $table->float('inversion')->nullable();
            $table->float('gastos_opertivos')->nullable();
            $table->float('impuestos')->nullable();
            $table->float('gastos_administrativos')->nullable();
            $table->float('comision')->nullable();
            $table->float('utilidad')->nullable();
            $table->date('fecha_pago')->nullable();
            $table->float('monto_pago')->nullable();
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
