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
    {!! Form::open(['url' => action([\Modules\Licitacion\Http\Controllers\LicitacionController::class, 'store']), 'method' => 'post',
    'id' => 'tender_add_form']) !!}
    @component('components.widget', ['class' => 'box-primary'])
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('code', __('licitacion::lang.tender_code') . ':*') !!}
                {!! Form::text('code', null , ['class' => 'form-control', 'required',
                'placeholder' => __('licitacion::lang.tender_code')]); !!}
            </div>
        </div>	
		<div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('entity', __('licitacion::lang.entity') . ':*') !!}
                {!! Form::text('entity', null , ['class' => 'form-control', 'required',
                'placeholder' => __('licitacion::lang.entity')]); !!}
            </div>
        </div>	
		<div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('responsible', __('licitacion::lang.responsible') . ':*') !!}
                {!! Form::text('responsible', null , ['class' => 'form-control', 'required',
                'placeholder' => __('licitacion::lang.responsible')]); !!}
            </div>
        </div>	
		<div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('tender_status', __('licitacion::lang.tender_status') . ':*') !!}
                {!! Form::text('tender_status', null , ['class' => 'form-control', 'required',
                'placeholder' => __('licitacion::lang.tender_status')]); !!}
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
<!-- /.content -->

@endsection

@section('javascript')

<script src="{{ asset('js/product.js?v=' . $asset_v) }}"></script>

<script type="text/javascript">
    $(document).ready(function() {
        __page_leave_confirmation('#tender_add_form');
    });
</script>
@endsection