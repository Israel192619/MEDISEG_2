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
                {!! Form::label('tender_status', __('licitacion::lang.tender_status') . ':*') !!} {{-- @show_tooltip(__('tooltip.order_status')) --}}
                {!! Form::select('tender_status', $orderStatuses, $default_purchase_status, ['class' => 'form-control select2','id' => 'status_id', 'placeholder' => __('messages.please_select'), 'required']); !!}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('city', __('licitacion::lang.city') . ':*') !!}
                {!! Form::select('city', $cities, null, ['class' => 'form-control select2','id' => 'city_id', 'placeholder' => __('messages.please_select'), 'required']); !!}
            </div>
        </div>
		<div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('phone', __('licitacion::lang.phone') . ':') !!}
                {!! Form::number('phone', null , ['class' => 'form-control',
                'placeholder' => __('licitacion::lang.phone')]); !!}
            </div>
        </div>
		<div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('cuce', __('licitacion::lang.cuce') . ':*') !!}
                {!! Form::text('cuce', null , ['class' => 'form-control', 'required',
                'placeholder' => __('licitacion::lang.cuce')]); !!}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('contract_object', __('licitacion::lang.contract_object') . ':') !!}
                {!! Form::text('contract_object', null , ['class' => 'form-control',
                'placeholder' => __('licitacion::lang.contract_object')]); !!}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('process_type', __('licitacion::lang.process_type') . ':*') !!}
                {!! Form::text('process_type', null , ['class' => 'form-control', 'required',
                'placeholder' => __('licitacion::lang.process_type')]); !!}
            </div>
        </div>
    </div>
    @endcomponent
    @component('components.widget', ['class' => 'box-primary'])
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('award_method', __('licitacion::lang.award_method') . ':*') !!}
                {!! Form::select('award_method', $award_method, null, ['class' => 'form-control select2','id' => 'award_method_id', 'placeholder' => __('messages.please_select'), 'required']); !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {!! Form::label('delivery_date', __('lang_v1.due_date') . ':') !!}
                @show_tooltip(__('licitacion::lang.delivery_date_tooltip'))
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </span>
                    {!! Form::text('delivery_date', null, ['class' => 'form-control', 'readonly']); !!}
                    <span class="input-group-addon">
                        <i class="fas fa-times-circle cursor-pointer clear_delivery_date"></i>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('month', __('licitacion::lang.month') . ':*') !!}
                {!! Form::text('month', null , ['class' => 'form-control', 'required',
                'placeholder' => __('licitacion::lang.month')]); !!}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('auction_time', __('licitacion::lang.auction_time') . ':*') !!}
                {!! Form::text('auction_time', null , ['class' => 'form-control', 'required',
                'placeholder' => __('licitacion::lang.auction_time')]); !!}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('requested_guarantees', __('licitacion::lang.requested_guarantees') . ':') !!}
                {!! Form::text('requested_guarantees', null , ['class' => 'form-control',
                'placeholder' => __('licitacion::lang.requested_guarantees')]); !!}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('sample_provision', __('licitacion::lang.sample_provision') . ':') !!}
                <br>
                {!! Form::checkbox('sample_provision', 1, false, ['class' => 'input-icheck','style' => 'margin-top: 10px;']) !!}
                {!! Form::label('sample_provision', __('Sí')) !!}
                <div style="height: 20px;" class="extra-space"></div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('sample_address', __('licitacion::lang.sample_address') . ':') !!}
                {!! Form::text('sample_address', null , ['class' => 'form-control',
                'placeholder' => __('licitacion::lang.sample_address')]); !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {!! Form::label('process_upload_date', __('licitacion::lang.process_upload_date') . ':') !!}
                @show_tooltip(__('licitacion::lang.expected_process_upload_date'))
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </span>
                    {!! Form::text('process_upload_date', null, ['class' => 'form-control', 'readonly']); !!}
                    <span class="input-group-addon">
                        <i class="fas fa-times-circle cursor-pointer clear_process_upload_date"></i>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('result', __('licitacion::lang.result') . ':*') !!}
                {!! Form::text('result', null , ['class' => 'form-control', 'required',
                'placeholder' => __('licitacion::lang.result')]); !!}
            </div>
        </div>
    </div>
    @endcomponent
    @component('components.widget', ['class' => 'box-primary'])
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('product_shipment', __('licitacion::lang.product_shipment') . ':*') !!}
                {!! Form::number('product_shipment', null , ['class' => 'form-control', 'required',
                'placeholder' => __('licitacion::lang.product_shipment')]); !!}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('documentation_shipment', __('licitacion::lang.documentation_shipment') . ':*') !!}
                {!! Form::number('documentation_shipment', null , ['class' => 'form-control', 'required',
                'placeholder' => __('licitacion::lang.documentation_shipment')]); !!}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('samples', __('licitacion::lang.samples') . ':*') !!}
                {!! Form::number('samples', null , ['class' => 'form-control', 'required',
                'placeholder' => __('licitacion::lang.samples')]); !!}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('delivery_commission', __('licitacion::lang.delivery_commission') . ':') !!}
                {!! Form::number('delivery_commission', null , ['class' => 'form-control',
                'placeholder' => __('licitacion::lang.delivery_commission')]); !!}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('other_delivery_costs', __('licitacion::lang.other_delivery_costs') . ':') !!}
                {!! Form::number('other_delivery_costs', null , ['class' => 'form-control',
                'placeholder' => __('licitacion::lang.other_delivery_costs')]); !!}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('commissions', __('licitacion::lang.commissions') . ':%15') !!}
                {!! Form::number('commissions', null , ['class' => 'form-control','disabled', 
                'placeholder' => __('licitacion::lang.commissions')]); !!}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('policy_expenses', __('licitacion::lang.policy_expenses') . ':*') !!}
                {!! Form::number('policy_expenses', null , ['class' => 'form-control', 'required',
                'placeholder' => __('licitacion::lang.policy_expenses')]); !!}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('tax_solvency', __('licitacion::lang.tax_solvency') . ':*') !!}
                {!! Form::number('tax_solvency', null , ['class' => 'form-control', 'required',
                'placeholder' => __('licitacion::lang.tax_solvency')]); !!}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('policy', __('licitacion::lang.policy') . ':*') !!}
                {!! Form::number('policy', null , ['class' => 'form-control', 'required',
                'placeholder' => __('licitacion::lang.policy')]); !!}
            </div>
        </div>
    </div>
    @endcomponent
    @component('components.widget', ['class' => 'box-primary'])
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('sale_price', __('licitacion::lang.sale_price') . ':') !!}
                {!! Form::number('sale_price', null , ['class' => 'form-control','disabled', 
                'placeholder' => __('licitacion::lang.sale_price')]); !!}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('investment', __('licitacion::lang.investment') . ':') !!}
                {!! Form::number('investment', null , ['class' => 'form-control','disabled', 
                'placeholder' => __('licitacion::lang.investment')]); !!}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('operating_expenses', __('licitacion::lang.operating_expenses') . ':*') !!}
                {!! Form::number('operating_expenses', null , ['class' => 'form-control', 'required','disabled', 
                'placeholder' => __('licitacion::lang.operating_expenses')]); !!}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('taxes', __('licitacion::lang.taxes') . ':') !!}
                {!! Form::number('taxes', null , ['class' => 'form-control','disabled', 
                'placeholder' => __('licitacion::lang.taxes')]); !!}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('administrative_expenses', __('licitacion::lang.administrative_expenses') . ':') !!}
                {!! Form::number('administrative_expenses', null , ['class' => 'form-control', 'disabled', 
                'placeholder' => __('licitacion::lang.administrative_expenses')]); !!}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('commission', __('licitacion::lang.commission') . ':') !!}
                {!! Form::number('commission', null , ['class' => 'form-control', 'disabled', 
                'placeholder' => __('licitacion::lang.commission')]); !!}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('profit', __('licitacion::lang.profit') . ':') !!}
                {!! Form::number('profit', null , ['class' => 'form-control','disabled', 
                'placeholder' => __('licitacion::lang.profit')]); !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {!! Form::label('payment_date', __('licitacion::lang.payment_date') . ':') !!}
                {{-- @show_tooltip(__('licitacion::lang.payment_date')) --}}
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </span>
                    {!! Form::text('payment_date', $default_datetime, ['class' => 'form-control', 'readonly']); !!}
                    <span class="input-group-addon">
                        <i class="fas fa-times-circle cursor-pointer clear_payment_date"></i>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('payment_amount', __('licitacion::lang.payment_amount') . ':*') !!} 
                {!! Form::number('payment_amount', null , ['class' => 'form-control', 'required',
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
<div class="modal fade contact_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
	@include('contact.create', ['quick_add' => true])
</div>
<!-- /.content -->
{{-- <div class="modal fade register_details_modal" tabindex="-1" role="dialog" 
	aria-labelledby="gridSystemModalLabel">
</div>
<div class="modal fade close_register_modal" tabindex="-1" role="dialog" 
	aria-labelledby="gridSystemModalLabel">
</div>

<!-- quick product modal -->
<div class="modal fade quick_add_product_modal" tabindex="-1" role="dialog" aria-labelledby="modalTitle"></div>

<div class="modal fade types_of_service_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel"></div> --}}

@endsection

@section('javascript')
    <script src="{{ asset('js/pos.js?v=' . $asset_v) }}"></script>
    <script src="{{ asset('js/product.js?v=' . $asset_v) }}"></script>

    <script type="text/javascript">
    $(document).ready(function() {
        __page_leave_confirmation('#tender_add_form');
    });
    //
    $('#delivery_date').datetimepicker({
        format: moment_date_format + ' ' + moment_time_format,
        ignoreReadonly: true,
    });

    $(document).on('click', '.clear_delivery_date', function() {
        $('#delivery_date').data("DateTimePicker").clear();
    });
    //
    $('#process_upload_date').datetimepicker({
        format: moment_date_format + ' ' + moment_time_format,
        ignoreReadonly: true,
    });

    $(document).on('click', '.clear_process_upload_date', function() {
        $('#process_upload_date').data("DateTimePicker").clear();
    });
    //
    $('#payment_date').datetimepicker({
        format: moment_date_format + ' ' + moment_time_format,
        ignoreReadonly: true,
    });

    $(document).on('click', '.clear_payment_date', function() {
        $('#payment_date').data("DateTimePicker").clear();
    });
    $('#customer_id, #status_id, #city_id, #award_method_id').on('select2:open', function() {
        $('.select2-search__field').css({
            'background-color': '#E6E6FA',
            'color': '#000000'  // Establecer el color del texto
        });
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