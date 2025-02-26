@extends('layouts.app')
@section('title', __('licitacion::lang.create_tender'))

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1 class="tw-text-xl md:tw-text-3xl tw-font-bold tw-text-black">@lang('licitacion::lang.editar_impuestos')</h1>
    <!-- <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
    </ol> -->
</section>

<!-- Main content -->
<section class="content">
    {!! Form::open([
        'route' => ['impuestos.update', $licitacion->id],
        'method' => 'put',
        'id' => 'tax_edit_form'
    ]) !!}    
    
    @component('components.widget', ['class' => 'box-primary'])
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('porcentaje_comisiones', 'Porcentaje comisiones' . ':') !!}
                {!! Form::number('porcentaje_comisiones', $licitacion->porcentaje_comisiones ?? null, ['class' => 'form-control', 
                'placeholder' => 'Porcentaje comisiones']); !!}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('porcentaje_impuesto', 'Porcentaje impuesto' . ':') !!}
                {!! Form::number('porcentaje_impuesto', $licitacion->porcentaje_impuesto ?? null, ['class' => 'form-control', 
                'placeholder' => 'Porcentaje impuesto']); !!}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('porcentaje_gastos_administrativos', 'Porcentaje gastos administrativos' . ':') !!}
                {!! Form::number('porcentaje_gastos_administrativos', $licitacion->porcentaje_gastos_administrativos ?? null, ['class' => 'form-control', 
                'placeholder' => 'Porcentaje gastos administrativos']); !!}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('porcentaje_comision', 'Porcentaje comision' . ':') !!}
                {!! Form::number('porcentaje_comision', $licitacion->porcentaje_comision ?? null, ['class' => 'form-control', 
                'placeholder' => 'Porcentaje comision']); !!}
            </div>
        </div>
        

        
    </div>
    @endcomponent

    <div class="row">
        <div class="col-sm-12">
            <input type="hidden" name="submit_type" id="submit_type">
            <div class="text-center">
                <div class="btn-group">
                    
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

    $(document).ready(function() {
        __page_leave_confirmation('#tax_edit_form');
    });

    
    

</script>
@endsection