<div class="modal-dialog modal-xl no-print" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <button type="button" class="close no-print" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title" id="modalTitle"> @lang('licitacion::lang.tender') (<b>Codigo licitacion :</b> {{ $licitacion->codigo_de_licitacion }})
      </h4>
  </div>

  <div class="modal-body">
    <div class="row">
      <div class="col-xs-12">
          <p class="pull-right"><b>@lang('messages.date'):</b> {{ @format_date($licitacion->fecha_subida_proceso) }}</p>
      </div>
    </div>
    <div class="row">
      
      <div class="col-sm-4">
        <b>Codigo licitación: </b>{{ $licitacion->codigo_de_licitacion }}<br>
        <b>Entidad: </b>{{ $licitacion->entidad }}<br>
        <b>Estado: </b>{{ __('licitacion::lang.'.$licitacion->estado) }}<br>
        <b>Ciudad: </b>{{ __('licitacion::lang.'.$licitacion->ciudad) }}<br>
        <b>Telefono: </b>{{ $licitacion->telefono }}<br>
        <b>Cuce: </b>{{ $licitacion->cuce }}<br>

      </div>
      <div class="col-sm-4">
        <b>Objeto de contratacion: </b>{{ $licitacion->objeto_contratacion }}<br>
        <b>Tipo de proceso: </b>{{ $licitacion->tipo_de_proceso }}<br>
        <b>Forma de adjudicacion: </b>{{ __('licitacion::lang.'.$licitacion->forma_de_adjudicacion) }}<br>
        <b>Fecha de vencimiento: </b>{{ @format_date($licitacion->fecha_vencimiento) }}<br>
        <b>Mes: </b>{{ $licitacion->mes }}<br>
        <b>Hora de subasta: </b>{{ $licitacion->hora_de_subasta }}<br>
      </div>
      <div class="col-sm-3">
        <b>Garantias solicitadas: </b>{{ $licitacion->garantias_solicitadas }}<br>
        <b>Presentación de muestra: </b>
        @if($licitacion->presentacion_de_muestra == 1)
        {{ 'Sí'}}
        @else
        {{ 'No' }}
        @endif<br>
        <b>Dirección de muestra: </b>{{ $licitacion->direccion_de_muestra }}<br>
        <b>Fecha subida proceso: </b>{{ @format_date($licitacion->fecha_subida_proceso) }}<br>
        <b>Resultado: </b>{{ $licitacion->resultado }}<br>
      </div>
    </div>
    <br>
    <div class="row">
      <div class="col-sm-12 col-xs-12">
        <h4>{{ __('sale.products') }}:</h4>
      </div>

      <div class="col-sm-12 col-xs-12">
        <div class="table-responsive">
          @include('sale_pos.partials.sale_line_details')
        </div>
      </div>
    </div>
{{--     <div class="row">
      @php
        $total_paid = 0;
      @endphp
      @if($sell->type != 'sales_order')
      <div class="col-sm-12 col-xs-12">
        <h4>{{ __('sale.payment_info') }}:</h4>
      </div>
      <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="table-responsive">
          <table class="table bg-gray">
            <tr class="bg-green">
              <th>#</th>
              <th>{{ __('messages.date') }}</th>
              <th>{{ __('purchase.ref_no') }}</th>
              <th>{{ __('sale.amount') }}</th>
              <th>{{ __('sale.payment_mode') }}</th>
              <th>{{ __('sale.payment_note') }}</th>
            </tr>
            @foreach($sell->payment_lines as $payment_line)
              @php
                if($payment_line->is_return == 1){
                  $total_paid -= $payment_line->amount;
                } else {
                  $total_paid += $payment_line->amount;
                }
              @endphp
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ @format_date($payment_line->paid_on) }}</td>
                <td>{{ $payment_line->payment_ref_no }}</td>
                <td><span class="display_currency" data-currency_symbol="true">{{ $payment_line->amount }}</span></td>
                <td>
                  {{ $payment_types[$payment_line->method] ?? $payment_line->method }}
                  @if($payment_line->is_return == 1)
                    <br/>
                    ( {{ __('lang_v1.change_return') }} )
                  @endif
                </td>
                <td>@if($payment_line->note) 
                  {{ ucfirst($payment_line->note) }}
                  @else
                  --
                  @endif
                </td>
              </tr>
            @endforeach
          </table>
        </div>
      </div>
      @endif
      <div class="col-md-6 col-sm-12 col-xs-12 @if($sell->type == 'sales_order') col-md-offset-6 @endif">
        <div class="table-responsive">
          <table class="table bg-gray">
            <tr>
              <th>{{ __('sale.total') }}: </th>
              <td></td>
              <td><span class="display_currency pull-right" data-currency_symbol="true">{{ $sell->total_before_tax }}</span></td>
            </tr>
            <tr>
              <th>{{ __('sale.discount') }}:</th>
              <td><b>(-)</b></td>
              <td><div class="pull-right"><span class="display_currency" @if( $sell->discount_type == 'fixed') data-currency_symbol="true" @endif>{{ $sell->discount_amount }}</span> @if( $sell->discount_type == 'percentage') {{ '%'}} @endif</span></div></td>
            </tr>
            @if(in_array('types_of_service' ,$enabled_modules) && !empty($sell->packing_charge))
              <tr>
                <th>{{ __('lang_v1.packing_charge') }}:</th>
                <td><b>(+)</b></td>
                <td><div class="pull-right"><span class="display_currency" @if( $sell->packing_charge_type == 'fixed') data-currency_symbol="true" @endif>{{ $sell->packing_charge }}</span> @if( $sell->packing_charge_type == 'percent') {{ '%'}} @endif </div></td>
              </tr>
            @endif
            @if(session('business.enable_rp') == 1 && !empty($sell->rp_redeemed) )
              <tr>
                <th>{{session('business.rp_name')}}:</th>
                <td><b>(-)</b></td>
                <td> <span class="display_currency pull-right" data-currency_symbol="true">{{ $sell->rp_redeemed_amount }}</span></td>
              </tr>
            @endif
            <tr>
              <th>{{ __('sale.order_tax') }}:</th>
              <td><b>(+)</b></td>
              <td class="text-right">
                @if(!empty($order_taxes))
                  @foreach($order_taxes as $k => $v)
                    <strong><small>{{$k}}</small></strong> - <span class="display_currency pull-right" data-currency_symbol="true">{{ $v }}</span><br>
                  @endforeach
                @else
                0.00
                @endif
              </td>
            </tr>
            @if(!empty($line_taxes))
            <tr>
              <th>{{ __('lang_v1.line_taxes') }}:</th>
              <td></td>
              <td class="text-right">
                @if(!empty($line_taxes))
                  @foreach($line_taxes as $k => $v)
                    <strong><small>{{$k}}</small></strong> - <span class="display_currency pull-right" data-currency_symbol="true">{{ $v }}</span><br>
                  @endforeach
                @else
                0.00
                @endif
              </td>
            </tr>
            @endif
            <tr>
              <th>{{ __('sale.shipping') }}: @if($sell->shipping_details)({{$sell->shipping_details}}) @endif</th>
              <td><b>(+)</b></td>
              <td><span class="display_currency pull-right" data-currency_symbol="true">{{ $sell->shipping_charges }}</span></td>
            </tr>

            @if( !empty( $sell->additional_expense_value_1 )  && !empty( $sell->additional_expense_key_1 ))
              <tr>
                <th>{{ $sell->additional_expense_key_1 }}:</th>
                <td><b>(+)</b></td>
                <td><span class="display_currency pull-right" >{{ $sell->additional_expense_value_1 }}</span></td>
              </tr>
            @endif
            @if( !empty( $sell->additional_expense_value_2 )  && !empty( $sell->additional_expense_key_2 ))
              <tr>
                <th>{{ $sell->additional_expense_key_2 }}:</th>
                <td><b>(+)</b></td>
                <td><span class="display_currency pull-right" >{{ $sell->additional_expense_value_2 }}</span></td>
              </tr>
            @endif
            @if( !empty( $sell->additional_expense_value_3 )  && !empty( $sell->additional_expense_key_3 ))
              <tr>
                <th>{{ $sell->additional_expense_key_3 }}:</th>
                <td><b>(+)</b></td>
                <td><span class="display_currency pull-right" >{{ $sell->additional_expense_value_3 }}</span></td>
              </tr>
            @endif
            @if( !empty( $sell->additional_expense_value_4 ) && !empty( $sell->additional_expense_key_4 ))
              <tr>
                <th>{{ $sell->additional_expense_key_4 }}:</th>
                <td><b>(+)</b></td>
                <td><span class="display_currency pull-right" >{{ $sell->additional_expense_value_4 }}</span></td>
              </tr>
            @endif
            <tr>
              <th>{{ __('lang_v1.round_off') }}: </th>
              <td></td>
              <td><span class="display_currency pull-right" data-currency_symbol="true">{{ $sell->round_off_amount }}</span></td>
            </tr>
            <tr>
              <th>{{ __('sale.total_payable') }}: </th>
              <td></td>
              <td><span class="display_currency pull-right" data-currency_symbol="true">{{ $sell->final_total }}</span></td>
            </tr>
            @if($sell->type != 'sales_order')
            <tr>
              <th>{{ __('sale.total_paid') }}:</th>
              <td></td>
              <td><span class="display_currency pull-right" data-currency_symbol="true" >{{ $total_paid }}</span></td>
            </tr>
            <tr>
              <th>{{ __('sale.total_remaining') }}:</th>
              <td></td>
              <td>
                <!-- Converting total paid to string for floating point substraction issue -->
                @php
                  $total_paid = (string) $total_paid;
                @endphp
                <span class="display_currency pull-right" data-currency_symbol="true" >{{ $sell->final_total - $total_paid }}</span></td>
            </tr>
            @endif
          </table>
        </div>
      </div>
    </div> --}}
    <div class="row">
      <div class="col-md-6 col-sm-12 col-xs-12 @if($sell->type == 'sales_order') col-md-offset-6 @endif">
        <div class="table-responsive">
          <table class="table bg-gray">
            <tr>
              <th>Comisiones: </th>
              <td>{{ $licitacion->comisiones }}</td>
            </tr>
            <tr>
              <th>Precio de venta: </th>
              <td>{{ $licitacion->precio_venta }}</td>
            </tr>
            <tr>
              <th>Inversión: </th>
              <td>{{ $licitacion->inversion }}</td>
            </tr>
            <tr>
              <th>Gastos operativos: </th>
              <td>{{ $licitacion->gastos_opertivos }}</td>
            </tr>
            <tr>
              <th>Impuestos: </th>
              <td>{{ $licitacion->impuestos }}</td>
            </tr>
            <tr>
              <th>Gastos administrativos: </th>
              <td>{{ $licitacion->gastos_administrativos }}</td>
            </tr>
            <tr>
              <th>Comisión: </th>
              <td>{{ $licitacion->comision }}</td>
            </tr>
            <tr>
              <th>Utilidad: </th>
              <td>{{ $licitacion->utilidad }}</td>
            </tr>
          </table>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-6">
       {{--  <strong>{{ __( 'sale.sell_note')}}:</strong><br>
        <p class="well well-sm no-shadow bg-gray">
          @if($sell->additional_notes)
            {!! nl2br($sell->additional_notes) !!}
          @else
            --
          @endif
        </p> --}}
      </div>
      <div class="col-sm-6">
        {{-- <strong>{{ __( 'sale.staff_note')}}:</strong><br>
        <p class="well well-sm no-shadow bg-gray">
          @if($sell->staff_note)
            {!! nl2br($sell->staff_note) !!}
          @else
            --
          @endif
        </p>
      </div> --}}
    </div>
    <div class="row">
      <div class="col-md-12">
            {{-- <strong>{{ __('lang_v1.activities') }}:</strong><br>
            @includeIf('activity_log.activities', ['activity_type' => 'sell']) --}}
        </div>
    </div>
  </div>
  <div class="modal-footer">
    {{-- @if($sell->type != 'sales_order')
    <a href="#" class="print-invoice tw-dw-btn tw-dw-btn-success tw-text-white" data-href="{{route('sell.printInvoice', [$licitacion->id])}}?package_slip=true"><i class="fas fa-file-alt" aria-hidden="true"></i> @lang("lang_v1.packing_slip")</a>
    @endif
    @can('print_invoice')
      <a href="#" class="print-invoice tw-dw-btn tw-dw-btn-primary tw-text-white" data-href="{{route('sell.printInvoice', [$licitacion->id])}}"><i class="fa fa-print" aria-hidden="true"></i> @lang("lang_v1.print_invoice")</a>
    @endcan --}}
      <button type="button" class="tw-dw-btn tw-dw-btn-neutral tw-text-white no-print" data-dismiss="modal">@lang( 'messages.close' )</button>
    </div>
  </div>
</div>

  <script type="text/javascript">
    $(document).ready(function(){
      var element = $('div.modal-xl');
      __currency_convert_recursively(element);
    });
  </script>