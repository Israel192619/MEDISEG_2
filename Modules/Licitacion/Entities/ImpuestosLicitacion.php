<?php

namespace Modules\Licitacion\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class impuestosLicitacion extends Model
{
    use HasFactory;
    protected $table = 'impuestos_licitaciones';

    protected $fillable = [
        'porcentaje_comisiones',
        'porcentaje_impuesto',
        'porcentaje_gastos_administrativos',
        'porcentaje_comision'
    ];
    public $timestamps = false;
    
    /* protected static function newFactory()
    {
        return \Modules\Licitacion\Database\factories\ImpuestosLicitacionFactory::new();
    } */
}
