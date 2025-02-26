<?php

namespace Modules\Licitacion\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Business;
use App\BusinessLocation;
use App\User;
use App\Contact;
use App\Utils\BusinessUtil;
use App\Utils\ContactUtil;
use App\Utils\ModuleUtil;
use App\Utils\ProductUtil;
use App\Utils\TransactionUtil;
use Modules\Licitacion\Utils\LicitacionUtil;
use Modules\Licitacion\Entities\Licitaciones;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use App\TaxRate;
use App\Transaction;
use Spatie\Activitylog\Models\Activity;

class LicitacionController extends Controller
{
    /**
     * All Utils instance.
     */
    protected $contactUtil;

    protected $businessUtil;

    protected $licitacionUtil;

    protected $transactionUtil;

    protected $productUtil;
    protected $moduleUtil;
    public function __construct(
        ContactUtil $contactUtil,
        BusinessUtil $businessUtil,
        LicitacionUtil $licitacionUtil,
        TransactionUtil $transactionUtil, ModuleUtil $moduleUtil, ProductUtil $productUtil
    ) {
        $this->contactUtil = $contactUtil;
        $this->businessUtil = $businessUtil;
        $this->licitacionUtil = $licitacionUtil;
        $this->transactionUtil = $transactionUtil;
        $this->moduleUtil = $moduleUtil;
        $this->productUtil = $productUtil;

        $this->dummyPaymentLine = ['method' => '', 'amount' => 0, 'note' => '', 'card_transaction_number' => '', 'card_number' => '', 'card_type' => '', 'card_holder_name' => '', 'card_month' => '', 'card_year' => '', 'card_security' => '', 'cheque_number' => '', 'bank_account_number' => '',
            'is_return' => 0, 'transaction_no' => '', ];

        $this->shipping_status_colors = [
            'ordered' => 'bg-yellow',
            'packed' => 'bg-info',
            'shipped' => 'bg-navy',
            'delivered' => 'bg-green',
            'cancelled' => 'bg-red',
        ];
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        if (!auth()->user()->can('licitacion.view')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = request()->session()->get('user.business_id');

        $business_locations = BusinessLocation::forDropdown($business_id, false);
        $customers = Contact::customersDropdown($business_id, false);

        $sales_representative = User::forDropdown($business_id, false, false, true);

        $licitaciones = Licitaciones::where('estado','!=', 'anulado')->get();
        return view('licitacion::index')->with(
            compact('licitaciones', 'business_locations', 'customers', 'sales_representative')
        );
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $award_method = $this->licitacionUtil->tender_award_method();
        $cities = $this->licitacionUtil->tender_cities();
        $resultados = $this->licitacionUtil->get_result();
        $business_id = request()->session()->get('user.business_id');
        $months = $this->licitacionUtil->get_month();
        $walk_in_customer = $this->contactUtil->getWalkInCustomer($business_id);
        $default_datetime = $this->businessUtil->format_date('now', true);
        $orderStatuses = $this->licitacionUtil->tender_statuses();
        $default_purchase_status = null;
        return view('licitacion::create')->with(
            compact(
                'default_datetime',
                'walk_in_customer',
                'orderStatuses',
                'default_purchase_status',
                'cities',
                'award_method',
                'months',
                'resultados',
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //dd($request);

        $request->validate([
            'codigo_de_licitacion' => 'required',
            'responsable_licitacion' => 'required',
            'cuce' => 'required',
        ]);


        $request->merge([
            'fecha_vencimiento' => $this->licitacionUtil->uf_date(
                $request->input('fecha_vencimiento'), false
            ),
            'fecha_subida_proceso' => $this->licitacionUtil->uf_date(
                $request->input('fecha_subida_proceso'),false
            ),
            'fecha_pago' => $this->licitacionUtil->uf_date(
                $request->input('fecha_pago'),false
            ),
        ]);

        $output = ['success' => 1,
                'msg' => 'Licitacion creada',
            ];

        Licitaciones::create($request->all());
        if ($request->input('submit_type') == 'save_n_add_another') {
            return redirect()->route('licitaciones.create')->with('status', $output);
        }
        return redirect()->route('licitaciones.index')->with('status', $output);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        // if (!auth()->user()->can('sell.view') && !auth()->user()->can('direct_sell.access') && !auth()->user()->can('view_own_sell_only')) {
        //     abort(403, 'Unauthorized action.');
        // }
        $business_id = request()->session()->get('user.business_id');
        $taxes = TaxRate::where('business_id', $business_id)
                            ->pluck('name', 'id');
        $query = Transaction::where('business_id', $business_id)
                    ->where('custom_field_1', $id)
                    ->with(['contact', 'delivery_person_user', 'sell_lines' => function ($q) {
                        $q->whereNull('parent_sell_line_id');
                    }, 'sell_lines.product', 'sell_lines.product.unit', 'sell_lines.product.second_unit', 'sell_lines.variations', 'sell_lines.variations.product_variation', 'payment_lines', 'sell_lines.modifiers', 'sell_lines.lot_details', 'tax', 'sell_lines.sub_unit', 'table', 'service_staff', 'sell_lines.service_staff', 'types_of_service', 'sell_lines.warranties', 'media']);

        if (! auth()->user()->can('sell.view') && ! auth()->user()->can('direct_sell.access') && auth()->user()->can('view_own_sell_only')) {
            $query->where('transactions.created_by', request()->session()->get('user.id'));
        }

        $sell = $query->firstOrFail();

        $activities = Activity::forSubject($sell)
           ->with(['causer', 'subject'])
           ->latest()
           ->get();

        $line_taxes = [];
        foreach ($sell->sell_lines as $key => $value) {
            if (! empty($value->sub_unit_id)) {
                $formated_sell_line = $this->transactionUtil->recalculateSellLineTotals($business_id, $value);
                $sell->sell_lines[$key] = $formated_sell_line;
            }

            if (! empty($taxes[$value->tax_id])) {
                if (isset($line_taxes[$taxes[$value->tax_id]])) {
                    $line_taxes[$taxes[$value->tax_id]] += ($value->item_tax * $value->quantity);
                } else {
                    $line_taxes[$taxes[$value->tax_id]] = ($value->item_tax * $value->quantity);
                }
            }
        }

        $payment_types = $this->transactionUtil->payment_types($sell->location_id, true);
        $order_taxes = [];
        if (! empty($sell->tax)) {
            if ($sell->tax->is_tax_group) {
                $order_taxes = $this->transactionUtil->sumGroupTaxDetails($this->transactionUtil->groupTaxDetails($sell->tax, $sell->tax_amount));
            } else {
                $order_taxes[$sell->tax->name] = $sell->tax_amount;
            }
        }

        $business_details = $this->businessUtil->getDetails($business_id);
        $pos_settings = empty($business_details->pos_settings) ? $this->businessUtil->defaultPosSettings() : json_decode($business_details->pos_settings, true);
        $shipping_statuses = $this->transactionUtil->shipping_statuses();
        $shipping_status_colors = $this->shipping_status_colors;
        $common_settings = session()->get('business.common_settings');
        $is_warranty_enabled = ! empty($common_settings['enable_product_warranty']) ? true : false;

        $statuses = Transaction::sell_statuses();

        if ($sell->type == 'sales_order') {
            $sales_order_statuses = Transaction::sales_order_statuses(true);
            $statuses = array_merge($statuses, $sales_order_statuses);
        }
        $status_color_in_activity = Transaction::sales_order_statuses();
        $sales_orders = $sell->salesOrders();
        $licitacion = Licitaciones::findOrFail($id);       

        return view('licitacion::show')
            ->with(compact(
                'licitacion',
                'taxes',
                'sell',
                'payment_types',
                'order_taxes',
                'pos_settings',
                'shipping_statuses',
                'shipping_status_colors',
                'is_warranty_enabled',
                'activities',
                'statuses',
                'status_color_in_activity',
                'sales_orders',
                'line_taxes'
            ));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $award_method = $this->licitacionUtil->tender_award_method();
        $cities = $this->licitacionUtil->tender_cities();
        $resultados = $this->licitacionUtil->get_result();
        $orderStatuses = $this->licitacionUtil->tender_statuses();
        $licitacion = Licitaciones::find($id);
        $months = $this->licitacionUtil->get_month();
        $licitacion->fecha_vencimiento = Carbon::parse($licitacion->fecha_vencimiento)->format(session('business.date_format'));
        $licitacion->fecha_subida_proceso = Carbon::parse($licitacion->fecha_subida_proceso)->format(session('business.date_format'));
        $licitacion->	fecha_pago = Carbon::parse($licitacion->	fecha_pago)->format(session('business.date_format') );
        return view('licitacion::create')->with(
            compact('licitacion',
             'orderStatuses',
                        'cities',
                        'award_method',
                        'months',
                        'resultados')
        );
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {   
        $request->validate([
            'codigo_de_licitacion' => 'required',
            'responsable_licitacion' => 'required',
            'cuce' => 'required',
        ]);
        $licitacion = Licitaciones::findOrFail($id);

        
        $gastosOperativos = $request->envio_productos + $request->envio_documentacion + $request->muestras + $request->comision_de_entrega + $request->otros_gastos_de_entrega + $licitacion->comisiones + $request->gastos_poliza + $request->solvencia_fiscal + $request->poliza;

        $request->merge([
            'fecha_vencimiento' => $this->licitacionUtil->uf_date(
                $request->input('fecha_vencimiento'), false
            ),
            'fecha_subida_proceso' => $this->licitacionUtil->uf_date(
                $request->input('fecha_subida_proceso'),false
            ),
            'fecha_pago' => $this->licitacionUtil->uf_date(
                $request->input('fecha_pago'),false
            ),
            'gastos_opertivos' => $gastosOperativos
        ]);

        $licitacion->update($request->all());
        $output = ['success' => 1,
                'msg' => 'Licitacion Actualizada',
            ];
        return redirect()->route('licitaciones.index')->with('status', $output);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)    
    {
       

        /* return redirect()->route('licitaciones.index')->with('success', 'Licitacion Eliminada'); */

        if (request()->ajax()) {
            
            $licitacion = Licitaciones::find($id);
            $licitacion->estado = 'anulado';
            $licitacion->save();
            $output['success'] = true;
            $output['msg'] = trans('Licitacion eliminada');
            return $output;
        }
    }

    /**
     * Send the datatable response for tender.
     *
     * @return \Illuminate\Http\Response
     */
    public function getDraftDatables()
    {
        $sells = Licitaciones::where('estado', '!=', 'anulado')->get();
        return Datatables::of($sells)
            ->addColumn('action', function ($row) {
                $html =
                    '<div class="btn-group">
                                <button type="button" class="tw-dw-btn tw-dw-btn-xs tw-dw-btn-outline  tw-dw-btn-info tw-w-max dropdown-toggle"
                                    data-toggle="dropdown" aria-expanded="false">' .
                    __('messages.actions') .
                    '<span class="caret"></span><span class="sr-only">Toggle Dropdown
                                    </span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-left" role="menu">
                                    <li>
                                    <a href="#" data-href="' .
                    action(
                        [\Modules\Licitacion\Http\Controllers\LicitacionController::class, 'show'],
                        [$row->id]
                    ) .
                    '" class="btn-modal" data-container=".view_modal">
                                        <i class="fas fa-eye" aria-hidden="true"></i>' .
                    __('messages.view') .
                    '
                                    </a>
                                    </li>';

                if (
                    auth()->user()->can('draft.update') ||
                    auth()->user()->can('quotation.update')
                ) {
                    if ($row->is_direct_sale == 1) {
                        $html .=
                            '<li>
                                            <a target="_blank" href="' .
                            action(
                                [
                                    \Modules\Licitacion\Http\Controllers\LicitacionController::class,
                                    'edit',
                                ],
                                [$row->id]
                            ) .
                            '">
                                                <i class="fas fa-edit"></i>' .
                            __('messages.edit') .
                            '
                                            </a>
                                        </li>';
                    } else {
                        $html .=
                            '<li>
                                            <a href="' .
                            action(
                                [
                                    \Modules\Licitacion\Http\Controllers\LicitacionController::class,
                                    'edit',
                                ],
                                [$row->id]
                            ) .
                            '">
                                                <i class="fas fa-edit"></i>' .
                            __('messages.edit') .
                            '
                                            </a>
                                        </li>';
                    }
                }

                $html .=
                    '<li>
                                    <a href="#" class="print-invoice" data-href="' .
                    route('sell.printInvoice', [$row->id]) .
                    '"><i class="fas fa-print" aria-hidden="true"></i>' .
                    __('messages.print') .
                    '</a>
                                </li>';

                if (config('constants.enable_download_pdf')) {
                    $sub_status = $row->sub_status == 'proforma' ? 'proforma' : '';
                    $html .=
                        '<li>
                                        <a href="' .
                        route('quotation.downloadPdf', [
                            'id' => $row->id,
                            'sub_status' => $sub_status,
                        ]) .
                        '" target="_blank">
                                            <i class="fas fa-print" aria-hidden="true"></i>' .
                        __('lang_v1.download_pdf') .
                        '
                                        </a>
                                    </li>';
                }

                /* if ((auth()->user()->can('sell.create') || auth()->user()->can('direct_sell.access')) && config('constants.enable_convert_draft_to_invoice')) {
                            $html .= '<li>
                                        <a href="'.action([\Modules\Licitacion\Http\Controllers\LicitacionController::class, 'convertToInvoice'], [$row->id]).'" class="convert-draft"><i class="fas fa-sync-alt"></i>'.__('lang_v1.convert_to_invoice').'</a>
                                    </li>';
                    } */

                /* if ($row->sub_status != 'proforma') {
                            $html .= '<li>
                                        <a href="'.action([\Modules\Licitacion\Http\Controllers\LicitacionController::class, 'convertToProforma'], [$row->id]).'" class="convert-to-proforma"><i class="fas fa-sync-alt"></i>'.__('lang_v1.convert_to_proforma').'</a>
                                    </li>';
                     } */

                if (
                    auth()->user()->can('draft.delete') ||
                    auth()->user()->can('quotation.delete')
                ) {
                    $html .='<li>
                        <a href="'.action([\Modules\Licitacion\Http\Controllers\LicitacionController::class,'destroy',],[$row->id]).'" class="delete-sale"><i class="fas fa-trash"></i>'.__('messages.delete').'</a></li>';
                }

                $html .= '</ul></div>';

                return $html;
            })->editColumn('estado', function ($row) {
                if ($row->estado == 'delivered') {
                    return 'Entregado';
                }
                if ($row->estado == 'lost') {
                    return 'Perdido';
                }
                if ($row->estado == 'won') {
                    return 'Ganado';
                }
                if ($row->estado == 'uploaded') {
                    return 'Subido';
                }
                if ($row->estado == 'verified') {
                    return 'Verificado';
                }
                if ($row->estado == 'pending') {
                    return 'Espera';
                }
                if ($row->estado == 'canceled') {
                    return 'Anulado';
                }
                return $row->estado;
            })->editColumn('ciudad', function ($row) {
                if ($row->ciudad == 'la_paz') {
                    return 'La Paz';
                }
                if ($row->ciudad == 'oruro') {
                    return 'Oruro';
                }
                if ($row->ciudad == 'potosi') {
                    return 'Potosi';
                }
                if ($row->ciudad == 'cochabamba') {
                    return 'Cochabamba';
                }
                if ($row->ciudad == 'chuquisaca') {
                    return 'Chuquisaca';
                }
                if ($row->ciudad == 'tarija') {
                    return 'Tarija';
                }
                if ($row->ciudad == 'pando') {
                    return 'Pando';
                }
                if ($row->ciudad == 'beni') {
                    return 'Beni';
                }
                if ($row->ciudad == 'santa_cruz') {
                    return 'Santa Cruz';
                }
                if ($row->ciudad == 'sucre') {
                    return 'Sucre';
                }
                return $row->ciudad;

            })->editColumn('forma_de_adjudicacion', function ($row) {
                if ($row->forma_de_adjudicacion == 'per_item') {
                    return 'Por Item';
                }
                if ($row->forma_de_adjudicacion == 'per_lote') {
                    return 'Por Lote';
                }
                if ($row->forma_de_adjudicacion == 'total') {
                    return 'Total';
                }
                return $row->forma_de_adjudicacion;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
