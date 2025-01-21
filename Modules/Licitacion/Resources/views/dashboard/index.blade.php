@extends('layouts.app')
{{-- @section('title', __('repair::lang.repair') . ' '. __('business.dashboard')) --}}

@section('content')
{{-- @include('repair::layouts.nav') --}}

<!-- Content Header (Page header) -->
<section class="content-header no-print">
    <h1>
    	@lang('licitacion::lang.tender')
    	<small>@lang('business.dashboard')</small>
    </h1>
</section>
<!-- Main content -->
<section class="content no-print">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-solid">
				<div class="box-header with-border">
					<h4 class="box-title">@lang('licitacion::lang.tender_form')</h4>
				</div>
				<div class="box-body">
					<div class="row">
				        Esto es una prueba
					</div>
				</div>
			</div>
		</div>
	</div>
	{{-- @if(in_array('service_staff', $enabled_modules))
		<div class="row">
		    <div class="col-xs-12">
		        @component('components.widget')
		            @slot('title')
		                @lang('repair::lang.job_sheets_by_service_staff')
		            @endslot
		            <div class="table-responsive">
						<table class="table table-striped">
							<thead>
								<tr>
									<th>#</th>
									<th>@lang('restaurant.service_staff')</th>
									<th>@lang('repair::lang.total_job_sheets')</th>
								</tr>
							</thead>
							<tbody>
								@foreach($job_sheets_by_service_staff as $job_sheet)
									<tr>
										<td>{{$loop->iteration}}</td>
										<td>{{$job_sheet->service_staff}}</td>
										<td>{{$job_sheet->total_job_sheets}}</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
		        @endcomponent
		    </div>
		</div>
	@endif --}}
	{{-- <div class="row">
	    <div class="col-xs-12">
	        @component('components.widget')
	            @slot('title')
	                @lang('repair::lang.trending_brands')
	            @endslot
	            {!!$trending_brand_chart->container()!!}
	        @endcomponent
	    </div>
	</div>
	<div class="row">
	    <div class="col-xs-12">
	        @component('components.widget')
	            @slot('title')
	                @lang('repair::lang.trending_devices')
	            @endslot
	            {!!$trending_devices_chart->container()!!}
	        @endcomponent
	    </div>
	</div>
	<div class="row">
	    <div class="col-xs-12">
	        @component('components.widget')
	            @slot('title')
	                @lang('repair::lang.trending_device_models')
	            @endslot
	            {!!$trending_dm_chart->container()!!}
	        @endcomponent
	    </div>
	</div> --}}
</section>
@stop
@section('javascript')
	{{-- {!!$trending_devices_chart->script()!!}
	{!!$trending_dm_chart->script()!!}
	{!!$trending_brand_chart->script()!!} --}}
@endsection