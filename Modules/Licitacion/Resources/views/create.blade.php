@extends('layouts.app')
@section('title', __('licitacion::lang.create_tender'))

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1 class="tw-text-xl md:tw-text-3xl tw-font-bold tw-text-black">@lang('licitacion::lang.create_tender')</h1>
    <!-- <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
    </ol> -->
</section>

<!-- Main content -->
<section class="content">
    {!! Form::open([  
        'route' => isset($licitacion) ? ['update']:['store'], 
        'method' => isset($licitacion) ? 'put':'post',
        'id' => 'tender_add_form']) !!}
    @component('components.widget', ['class' => 'box-primary'])
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('codigo_de_licitacion', __('licitacion::lang.tender_code') . ':*') !!}
                {!! Form::text('codigo_de_licitacion', $licitacion->codigo_de_licitacion ?? $licitacion->codigo_de_licitacion ?? null, ['class' => 'form-control', 'required',
                'placeholder' => __('licitacion::lang.tender_code')]); !!}
            </div>
        </div>	
		<div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('entidad', __('licitacion::lang.entity') . ':*') !!}
                {!! Form::text('entidad', $licitacion->entidad ?? null, ['class' => 'form-control', 'required',
                'placeholder' => __('licitacion::lang.entity')]); !!}
            </div>
        </div>
		<div class="col-sm-4">  
            <div class="form-group">
                {!! Form::label('responsable_licitacion', __('licitacion::lang.responsible') . ':*') !!}
                {!! Form::text('responsable_licitacion', $licitacion->responsable_licitacion ?? null, ['class' => 'form-control', 'required',
                'placeholder' => __('licitacion::lang.responsible')]); !!}
            </div>
        </div>	
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('estado', __('licitacion::lang.tender_status') . ':*') !!} {{-- @show_tooltip(__('tooltip.order_status')) --}}
                {!! Form::select('estado', $orderStatuses, $licitacion->estado ?? null, ['class' => 'form-control select2','id' => 'status_id', 'placeholder' => __('messages.please_select'), 'required']); !!}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('ciudad', __('licitacion::lang.city') . ':*') !!}
                {!! Form::select('ciudad', $cities, $licitacion->ciudad ?? null, ['class' => 'form-control select2','id' => 'city_id', 'placeholder' => __('messages.please_select'), 'required']); !!}
            </div>
        </div>
		<div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('telefono', __('licitacion::lang.phone') . ':*') !!}
                {!! Form::number('telefono', $licitacion->telefono ?? null, ['class' => 'form-control', 'required',
                'placeholder' => __('licitacion::lang.phone')]); !!}
            </div>
        </div>
		<div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('cuce', __('licitacion::lang.cuce') . ':*') !!}
                {!! Form::text('cuce', $licitacion->cuce ?? null, ['class' => 'form-control', 'required',
                'placeholder' => __('licitacion::lang.cuce')]); !!}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('objeto_contratacion', __('licitacion::lang.contract_object') . ':') !!}
                {!! Form::text('objeto_contratacion', $licitacion->objeto_contratacion ?? null, ['class' => 'form-control',
                'placeholder' => __('licitacion::lang.contract_object')]); !!}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('tipo_de_proceso', __('licitacion::lang.process_type') . ':*') !!}
                {!! Form::text('tipo_de_proceso', $licitacion->tipo_de_proceso ?? null, ['class' => 'form-control', 'required',
                'placeholder' => __('licitacion::lang.process_type')]); !!}
            </div>
        </div>
    </div>
    @endcomponent
    @component('components.widget', ['class' => 'box-primary'])
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('forma_de_adjudicacion', __('licitacion::lang.award_method') . ':*') !!}
                {!! Form::select('forma_de_adjudicacion', $award_method, $licitacion->forma_de_adjudicacion ?? null, ['class' => 'form-control select2','id' => 'award_method_id', 'placeholder' => __('messages.please_select'), 'required']); !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {!! Form::label('fecha_vencimiento', __('lang_v1.due_date') . ':') !!}
                @show_tooltip(__('licitacion::lang.delivery_date_tooltip'))
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </span>
                    {!! Form::text('fecha_vencimiento', $licitacion->fecha_vencimiento ?? null, ['class' => 'form-control', 'readonly']); !!}
                    <span class="input-group-addon">
                        <i class="fas fa-times-circle cursor-pointer clear_delivery_date"></i>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('mes', __('licitacion::lang.month') . ':*') !!}
                {!! Form::text('mes', $licitacion->mes ?? null, ['class' => 'form-control', 'required',
                'placeholder' => __('licitacion::lang.month')]); !!}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('hora_de_subasta', __('licitacion::lang.auction_time') . ':*') !!}
                {!! Form::text('hora_de_subasta', $licitacion->hora_de_subasta ?? null, ['class' => 'form-control', 'required',
                'placeholder' => __('licitacion::lang.auction_time')]); !!}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('garantias_solicitadas', __('licitacion::lang.requested_guarantees') . ':') !!}
                {!! Form::text('garantias_solicitadas', $licitacion->garantias_solicitadas ?? null, ['class' => 'form-control',
                'placeholder' => __('licitacion::lang.requested_guarantees')]); !!}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('presentacion_de_muestra', __('licitacion::lang.sample_provision') . ':') !!}
                <br>
                {!! Form::checkbox('presentacion_de_muestra', 1, $licitacion->presentacion_de_muestra ?? false, ['class' => 'input-icheck','style' => 'margin-top: 10px;']) !!}
                {!! Form::label('presentacion_de_muestra', __('Sí')) !!}
                <div style="height: 20px;" class="extra-space"></div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('direccion_de_muestra', __('licitacion::lang.sample_address') . ':') !!}
                {!! Form::text('direccion_de_muestra', $licitacion->direccion_de_muestra ?? null, ['class' => 'form-control',
                'placeholder' => __('licitacion::lang.sample_address')]); !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {!! Form::label('fecha_subida_proceso', __('licitacion::lang.process_upload_date') . ':') !!}
                @show_tooltip(__('licitacion::lang.expected_process_upload_date'))
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </span>
                    {!! Form::text('fecha_subida_proceso', $licitacion->fecha_subida_proceso ?? null, ['class' => 'form-control', 'readonly']); !!}
                    <span class="input-group-addon">
                        <i class="fas fa-times-circle cursor-pointer clear_process_upload_date"></i>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('resultado', __('licitacion::lang.result') . ':*') !!}
                {!! Form::text('resultado', $licitacion->resultado ?? null, ['class' => 'form-control', 'required',
                'placeholder' => __('licitacion::lang.result')]); !!}
            </div>
        </div>
    </div>
    @endcomponent
    @component('components.widget', ['class' => 'box-primary'])
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('envio_productos', __('licitacion::lang.product_shipment') . ':*') !!}
                {!! Form::number('envio_productos', $licitacion->envio_productos ?? null, ['class' => 'form-control', 'required',
                'placeholder' => __('licitacion::lang.product_shipment')]); !!}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('envio_documentacion', __('licitacion::lang.documentation_shipment') . ':*') !!}
                {!! Form::number('envio_documentacion', $licitacion->envio_documentacion ?? null, ['class' => 'form-control', 'required',
                'placeholder' => __('licitacion::lang.documentation_shipment')]); !!}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('muestras', __('licitacion::lang.samples') . ':*') !!}
                {!! Form::number('muestras', $licitacion->muestras ?? null, ['class' => 'form-control', 'required',
                'placeholder' => __('licitacion::lang.samples')]); !!}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('comision_de_entrega', __('licitacion::lang.delivery_commission') . ':') !!}comision_de_entrega
                {!! Form::number('comision_de_entrega', $licitacion->comision_de_entrega ?? null, ['class' => 'form-control',
                'placeholder' => __('licitacion::lang.delivery_commission')]); !!}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('otros_gastos_de_entrega', __('licitacion::lang.other_delivery_costs') . ':') !!}
                {!! Form::number('otros_gastos_de_entrega', $licitacion->otros_gastos_de_entrega ?? null, ['class' => 'form-control',
                'placeholder' => __('licitacion::lang.other_delivery_costs')]); !!}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('comisiones', __('licitacion::lang.commissions') . ':%15') !!}
                {!! Form::number('comisiones', $licitacion->comisiones ?? null, ['class' => 'form-control','disabled', 
                'placeholder' => __('licitacion::lang.commissions')]); !!}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('gastos_poliza', __('licitacion::lang.policy_expenses') . ':*') !!}
                {!! Form::number('gastos_poliza', $licitacion->gastos_poliza ?? null, ['class' => 'form-control', 'required',
                'placeholder' => __('licitacion::lang.policy_expenses')]); !!}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('solvencia_fiscal', __('licitacion::lang.tax_solvency') . ':*') !!}
                {!! Form::number('solvencia_fiscal', $licitacion->solvencia_fiscal ?? null, ['class' => 'form-control', 'required',
                'placeholder' => __('licitacion::lang.tax_solvency')]); !!}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('poliza', __('licitacion::lang.policy') . ':*') !!}
                {!! Form::number('poliza', $licitacion->poliza ?? null, ['class' => 'form-control', 'required',
                'placeholder' => __('licitacion::lang.policy')]); !!}
            </div>
        </div>
    </div>
    @endcomponent
    @component('components.widget', ['class' => 'box-primary'])
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('precio_venta', __('licitacion::lang.sale_price') . ':') !!}
                {!! Form::number('precio_venta', $licitacion->precio_venta ?? null, ['class' => 'form-control','disabled', 
                'placeholder' => __('licitacion::lang.sale_price')]); !!}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('inversion', __('licitacion::lang.investment') . ':') !!}
                {!! Form::number('inversion', $licitacion->inversion ?? null, ['class' => 'form-control','disabled', 
                'placeholder' => __('licitacion::lang.investment')]); !!}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('gastos_opertivos', __('licitacion::lang.operating_expenses') . ':') !!}
                {!! Form::number('gastos_opertivos', $licitacion->gastos_opertivos ?? null, ['class' => 'form-control','disabled', 
                'placeholder' => __('licitacion::lang.operating_expenses')]); !!}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('impuestos', __('licitacion::lang.taxes') . ':') !!}
                {!! Form::number('impuestos', $licitacion->impuestos ?? null, ['class' => 'form-control','disabled', 
                'placeholder' => __('licitacion::lang.taxes')]); !!}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('gastos_administrativos', __('licitacion::lang.administrative_expenses') . ':') !!}
                {!! Form::number('gastos_administrativos', $licitacion->gastos_administrativos ?? null, ['class' => 'form-control', 'disabled', 
                'placeholder' => __('licitacion::lang.administrative_expenses')]); !!}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('comision', __('licitacion::lang.commission') . ':') !!}
                {!! Form::number('comision', $licitacion->comision ?? null, ['class' => 'form-control', 'disabled', 
                'placeholder' => __('licitacion::lang.commission')]); !!}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('utilidad', __('licitacion::lang.profit') . ':') !!}
                {!! Form::number('utilidad', $licitacion->utilidad ?? null, ['class' => 'form-control','disabled', 
                'placeholder' => __('licitacion::lang.profit')]); !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {!! Form::label('fecha_pago', __('licitacion::lang.payment_date') . ':') !!}
                {{-- @show_tooltip(__('licitacion::lang.payment_date')) --}}
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </span>
                    {!! Form::text('fecha_pago', $licitacion->fecha_pago ?? $default_datetime, ['class' => 'form-control', 'readonly']); !!}
                    <span class="input-group-addon">
                        <i class="fas fa-times-circle cursor-pointer clear_payment_date"></i>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('monto_pago', __('licitacion::lang.payment_amount') . ':*') !!} 
                {!! Form::number('monto_pago', $licitacion->monto_pago ?? null, ['class' => 'form-control', 'required',
                'placeholder' => __('licitacion::lang.payment_amount')]); !!}
            </div>
        </div>

        
    </div>
    @endcomponent

    <div class="row">
        <div class="col-sm-12">
            <input type="hidden" name="submit_type" id="submit_type">
            <div class="text-center">
                <div class="btn-group">
                    <button type="submit" value="save_n_add_another" class="tw-dw-btn tw-dw-btn-lg bg-maroon submit_product_form">@lang('lang_v1.save_n_add_another')</button>

                    <button type="submit" value="submit" class="tw-dw-btn tw-dw-btn-primary tw-dw-btn-lg tw-text-white submit_product_form">@lang('messages.save')</button>
                </div>

            </div>
        </div>
    </div>
    {!! Form::close() !!}

</section>


@endsection

@section('javascript')

    <script type="text/javascript">
    //console.log($('#tender_add_form')); // Verifica si el formulario existe
    $(document).ready(function() {
        __page_leave_confirmation('#tender_add_form');
    });
    //
    $('#fecha_vencimiento').datetimepicker({
        format: moment_date_format + ' ' + moment_time_format,
        ignoreReadonly: true,
    });

    $(document).on('click', '.clear_delivery_date', function() {
        $('#fecha_vencimiento').data("DateTimePicker").clear();
    });
    //
    $('#fecha_subida_proceso').datetimepicker({
        format: moment_date_format + ' ' + moment_time_format,
        ignoreReadonly: true,
    });

    $(document).on('click', '.clear_process_upload_date', function() {
        $('#fecha_subida_proceso').data("DateTimePicker").clear();
    });
    //
    $('#fecha_pago').datetimepicker({
        format: moment_date_format + ' ' + moment_time_format,
        ignoreReadonly: true,
    });

    $(document).on('click', '.clear_payment_date', function() {
        $('#fecha_pago').data("DateTimePicker").clear();
    });
    $('#status_id, #city_id, #award_method_id').on('select2:open', function() {
        $('.select2-search__field').css({
            'background-color': '#E6E6FA',
            'color': '#000000'  // Establecer el color del texto
        });
    });

    $(document).on('click', '.submit_product_form', function(e) {
    e.preventDefault();
    var submit_type = $(this).attr('value');
    $('#submit_type').val(submit_type);
    if ($('form#tender_add_form').valid()) {
            $('form#tender_add_form').submit();
        }
    });

</script>
<style>
    @media (max-width: 991px) {
        .extra-space {
            display: none;
        }
    }
</style>
@endsection