@extends('layouts.app')
@section('title', __('licitacion::lang.impuestos'))

@section('content')
<section class="content-header">
	<h1 class="tw-text-xl md:tw-text-3xl tw-font-bold tw-text-black">@lang('licitacion::lang.impuestos')
		<small class="tw-text-sm md:tw-text-base tw-text-gray-700 tw-font-semibold">@lang('licitacion::lang.administra_tus_impuestos')</small>
	</h1>
</section>
<!-- Main content -->
<section class="content no-print">
@component('components.widget', ['class' => 'box-primary'])
		<table class="table table-bordered table-striped ajax_view" id="sell_table" style="width: 100%;">
			<thead>
				<tr>
                    <th>@lang('messages.action')</th>
					<th>Porcentaje comisiones</th>
					<th>Porcentaje impuestos</th>
					<th>Porcentaje gastos administrativos</th>
					<th>Porcentaje comision</th>
				</tr>
			</thead>
		</table>
@endcomponent
</section>
@stop
@section('javascript')
<script type="text/javascript">
$(document).ready( function(){
    //Date range as a button
    
    $('#sell_list_filter_date_range').on('cancel.daterangepicker', function(ev, picker) {
        $('#sell_list_filter_date_range').val('');
        sell_table.ajax.reload();
    });

    sell_table = $('#sell_table').DataTable({
        processing: true,
        serverSide: true,
        fixedHeader:false,
        aaSorting: [[1, 'asc']],
        "ajax": {
            "url": '/licitacion/data',
            /* success: function (response) {
        console.log("Respuesta del servidor:", response);
    }, */
        },
        columnDefs: [ {
            "targets": 2,
            "orderable": false,
            "searchable": false
        } ],
        scrollY: "75vh",
        scrollX: true,
        scrollCollapse: true,
        columns: [
            {data: 'action',name: 'action',orderable: false,"searchable": false},
            { data: 'porcentaje_comisiones', name: 'porcentaje_comisiones'},
            { data: 'porcentaje_impuesto', name: 'porcentaje_impuesto'},
            { data: 'porcentaje_gastos_administrativos', name: 'porcentaje_gastos_administrativos'},
            { data: 'porcentaje_comision', name: 'porcentaje_comision'},
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
            location.reload();
        });
    });
});
</script>
@endsection
