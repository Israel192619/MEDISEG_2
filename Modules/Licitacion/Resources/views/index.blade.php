@extends('layouts.app')
@section('title', __('licitacion::lang.tender'))

@section('content')
<section class="content-header">
	<h1 class="tw-text-xl md:tw-text-3xl tw-font-bold tw-text-black">@lang('licitacion::lang.tender')
		<small class="tw-text-sm md:tw-text-base tw-text-gray-700 tw-font-semibold">@lang('licitacion::lang.manage_tender')</small>
	</h1>
</section>
<!-- Main content -->
<section class="content no-print">
	@component('components.filters', ['title' => __('report.filters')])
	<div class="col-md-3">
		<div class="form-group">
			{!! Form::label('sell_list_filter_location_id',  __('purchase.business_location') . ':') !!}

			{!! Form::select('sell_list_filter_location_id', $business_locations, null, ['class' => 'form-control select2', 'style' => 'width:100%', 'placeholder' => __('lang_v1.all') ]); !!}
		</div>
	</div>
	<div class="col-md-3">
		<div class="form-group">
			{!! Form::label('sell_list_filter_customer_id',  __('contact.customer') . ':') !!}
			{!! Form::select('sell_list_filter_customer_id', $customers, null, ['class' => 'form-control select2', 'style' => 'width:100%', 'placeholder' => __('lang_v1.all')]); !!}
		</div>
	</div>

	<div class="col-md-3">
		<div class="form-group">
			{!! Form::label('sell_list_filter_date_range', __('report.date_range') . ':') !!}
			{!! Form::text('sell_list_filter_date_range', null, ['placeholder' => __('lang_v1.select_a_date_range'), 'class' => 'form-control', 'readonly']); !!}
		</div>
	</div>
	<div class="col-md-3">
		<div class="form-group">
			{!! Form::label('created_by',  __('report.user') . ':') !!}
			{!! Form::select('created_by', $sales_representative, null, ['class' => 'form-control select2', 'style' => 'width:100%']); !!}
		</div>
	</div>
@endcomponent
@component('components.widget', ['class' => 'box-primary'])
	@slot('tool')
		<div class="box-tools">

			<a class="tw-dw-btn tw-bg-gradient-to-r tw-from-indigo-600 tw-to-blue-500 tw-font-bold tw-text-white tw-border-none tw-rounded-full pull-right"
				href="{{action([\Modules\Licitacion\Http\Controllers\LicitacionController::class, 'create'], ['status' => 'tender'])}}">
				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
					stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
					class="icon icon-tabler icons-tabler-outline icon-tabler-plus">
					<path stroke="none" d="M0 0h24v24H0z" fill="none" />
					<path d="M12 5l0 14" />
					<path d="M5 12l14 0" />
				</svg> @lang('licitacion::lang.create_tender')
			</a>
		</div>
	@endslot
	<div class="table-responsive">
		<table class="table table-bordered table-striped ajax_view" id="sell_table">
			<thead>
				<tr>
                    <th>@lang('messages.action')</th>
					<th>Codigo_de Licitacion</th>
					<th>Entidad</th>
					<th>Responsable Licitacion</th>
					<th>Estado</th>
					<th>Ciudad</th>
					<th>Telefono</th>
					<th>Cuce</th>
					<th>Objeto Contratacion</th>
				</tr>
			</thead>
		</table>
	</div>
@endcomponent
</section>
@stop
@section('javascript')
<script type="text/javascript">
$(document).ready( function(){
    //Date range as a button
    $('#sell_list_filter_date_range').daterangepicker(
        dateRangeSettings,
        function (start, end) {
            $('#sell_list_filter_date_range').val(start.format(moment_date_format) + ' ~ ' + end.format(moment_date_format));
            sell_table.ajax.reload();
        }
    );
    $('#sell_list_filter_date_range').on('cancel.daterangepicker', function(ev, picker) {
        $('#sell_list_filter_date_range').val('');
        sell_table.ajax.reload();
    });

    sell_table = $('#sell_table').DataTable({
        processing: true,
        serverSide: true,
        fixedHeader:false,
        aaSorting: [[1, 'desc']],
        "ajax": {
            "url": '/licitacion/dataTable',
        },
        columnDefs: [ {
            "targets": 7,
            "orderable": false,
            "searchable": false
        } ],
        scrollY: "75vh",
        scrollX: true,
        scrollCollapse: true,
        columns: [
            {data: 'action',name: 'action',orderable: false,"searchable": false},
            { data: 'codigo_de_licitacion', name: 'codigo_de_licitacion'  },
            { data: 'entidad', name: 'entidad'},
            { data: 'responsable_licitacion', name: 'responsable_licitacion'},
            { data: 'estado', name: 'estado'},
            { data: 'ciudad', name: 'ciudad'},
            { data: 'telefono', name: 'telefono'},
            { data: 'cuce', name: 'cuce'},
            { data: 'objeto_contratacion', name: 'objeto_contratacion'}
        ],
        "fnDrawCallback": function (oSettings) {
            __currency_convert_recursively($('#sell_table'));
        }
    });

    $(document).on('change', '#sell_list_filter_location_id, #sell_list_filter_customer_id, #created_by',  function() {
        sell_table.ajax.reload();
    });

    $(document).on('click', 'a.convert-to-proforma', function(e){
        e.preventDefault();
        swal({
            title: LANG.sure,
            icon: 'warning',
            buttons: true,
            dangerMode: true,
        }).then(confirm => {
            if (confirm) {
                var url = $(this).attr('href');
                $.ajax({
                    method: 'GET',
                    url: url,
                    dataType: 'json',
                    success: function(result) {
                        if (result.success == true) {
                            toastr.success(result.msg);
                            sell_table.ajax.reload();
                        } else {
                            toastr.error(result.msg);
                        }
                    },
                });
            }
        });
    });
});
</script>
@endsection
