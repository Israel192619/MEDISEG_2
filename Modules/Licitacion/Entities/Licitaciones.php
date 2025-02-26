<?php

namespace Modules\Licitacion\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Licitaciones extends Model
{
    use HasFactory;

    protected $table = 'licitaciones';
    protected $fillable = [
        'codigo_de_licitacion',
        'entidad',
        'responsable_licitacion',
        'estado',
        'ciudad',
        'telefono',
        'cuce',
        'objeto_contratacion',
        'tipo_de_proceso',
        'forma_de_adjudicacion',
        'fecha_vencimiento',
        'mes',
        'hora_de_subasta',
        'garantias_solicitadas',
        'presentacion_de_muestra',
        'direccion_de_muestra',
        'fecha_subida_proceso',
        'resultado',
        'envio_productos',
        'envio_documentacion',
        'muestras',
        'comision_de_entrega',
        'otros_gastos_de_entrega',
        'comisiones',
        'gastos_poliza',
        'solvencia_fiscal',
        'poliza',
        'precio_venta',
        'inversion',
        'gastos_opertivos',
        'impuestos',
        'gastos_administrativos',
        'comision',
        'utilidad',
        'fecha_pago',
        'monto_pago'
    ];
    
    public $timestamps = false;
    
    
        
   /*  protected static function newFactory()
    {
        return \Modules\Licitacion\Database\factories\LicitacionesFactory::new();
    } */
}
