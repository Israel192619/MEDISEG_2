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
use Modules\Licitacion\Utils\LicitacionUtil;
use  Modules\Licitacion\Entities\Licitaciones;
use Yajra\DataTables\Facades\DataTables;

class LicitacionController extends Controller
{
    
    
        /**
     * All Utils instance.
     */
    protected $contactUtil;

    protected $businessUtil;

    protected $licitacionUtil;

/*     protected $transactionUtil;

    protected $productUtil; */
    public function __construct(ContactUtil $contactUtil, BusinessUtil $businessUtil, LicitacionUtil $licitacionUtil/* , TransactionUtil $transactionUtil, ModuleUtil $moduleUtil, ProductUtil $productUtil */)
    {
        $this->contactUtil = $contactUtil;
        $this->businessUtil = $businessUtil;
        $this->licitacionUtil = $licitacionUtil;
        /* , $this->transactionUtil,
        /* $this->transactionUtil = $transactionUtil;
        $this->moduleUtil = $moduleUtil;
        $this->productUtil = $productUtil; */

        /* $this->dummyPaymentLine = ['method' => '', 'amount' => 0, 'note' => '', 'card_transaction_number' => '', 'card_number' => '', 'card_type' => '', 'card_holder_name' => '', 'card_month' => '', 'card_year' => '', 'card_security' => '', 'cheque_number' => '', 'bank_account_number' => '',
            'is_return' => 0, 'transaction_no' => '', ];

        $this->shipping_status_colors = [
            'ordered' => 'bg-yellow',
            'packed' => 'bg-info',
            'shipped' => 'bg-navy',
            'delivered' => 'bg-green',
            'cancelled' => 'bg-red',
        ]; */
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        
        if (! auth()->user()->can('licitacion.view')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = request()->session()->get('user.business_id');

        $business_locations = BusinessLocation::forDropdown($business_id, false);
        $customers = Contact::customersDropdown($business_id, false);

        $sales_representative = User::forDropdown($business_id, false, false, true);
        
        $licitaciones = Licitaciones::get();
        return view('licitacion::index')->with(compact('licitaciones','business_locations', 'customers', 'sales_representative'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {    
        $award_method = $this->licitacionUtil->tender_award_method();
        $cities = $this->licitacionUtil->tender_cities();
        $business_id = request()->session()->get('user.business_id');
        $walk_in_customer = $this->contactUtil->getWalkInCustomer($business_id);
        $default_datetime = $this->businessUtil->format_date('now', true);
        $orderStatuses = $this->licitacionUtil->tender_statuses();
        $default_purchase_status = null;
        return view('licitacion::create')
        ->with(compact(
            'default_datetime',
            'walk_in_customer',
                        'orderStatuses',
                    'default_purchase_status',
                        'cities',
                    'award_method'));
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
        
        $request->merge(['fecha_vencimiento' => $this->licitacionUtil->uf_date($request->input('fecha_vencimiento'), time: true)]);

        Licitaciones::create($request->all());
        return redirect()->route('index')->with('success', 'Licitacion Creada');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('licitacion::show');
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
        $orderStatuses = $this->licitacionUtil->tender_statuses();
        $licitacion = Licitaciones::find($id);
        return view('licitacion::create')->with(compact('licitacion','orderStatuses','cities','award_method'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, Licitaciones $licitacion)
    {
        $request->validate([
            'codigo_de_licitacion' => 'required',
            'responsable_licitacion' => 'required',
            'cuce' => 'required',
        ]);
        $licitacion->update($request->all());
        return redirect()->route('index')->with('success', 'Licitacion Actualizada');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $licitacion = find($id);
        $licitacion->estado = 'anulado';
        $licitacion->save();
        
        return redirect()->route('index')->with('success', 'Licitacion Eliminada');
    }

    
    /**
     * Send the datatable response for tender.
     *
     * @return \Illuminate\Http\Response
     */
    public function getDraftDatables()
    {
            $sells = Licitaciones::all();
            return Datatables::of($sells)
                 ->addColumn(
                    'action', function ($row) {
                        $html = '<div class="btn-group">
                                <button type="button" class="tw-dw-btn tw-dw-btn-xs tw-dw-btn-outline  tw-dw-btn-info tw-w-max dropdown-toggle" 
                                    data-toggle="dropdown" aria-expanded="false">'.
                                    __('messages.actions').
                                    '<span class="caret"></span><span class="sr-only">Toggle Dropdown
                                    </span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-left" role="menu">
                                    <li>
                                    <a href="#" data-href="'.action([\Modules\Licitacion\Http\Controllers\LicitacionController::class, 'show'], [$row->id]).'" class="btn-modal" data-container=".view_modal">
                                        <i class="fas fa-eye" aria-hidden="true"></i>'.__('messages.view').'
                                    </a>
                                    </li>';

                        if (auth()->user()->can('draft.update') || auth()->user()->can('quotation.update')) {
                            if ($row->is_direct_sale == 1) {
                                $html .= '<li>
                                            <a target="_blank" href="'.action([\Modules\Licitacion\Http\Controllers\LicitacionController::class, 'edit'], [$row->id]).'">
                                                <i class="fas fa-edit"></i>'.__('messages.edit').'
                                            </a>
                                        </li>';
                            } else {
                                $html .= '<li>
                                            <a target="_blank" href="'.action([\Modules\Licitacion\Http\Controllers\LicitacionController::class, 'edit'], [$row->id]).'">
                                                <i class="fas fa-edit"></i>'.__('messages.edit').'
                                            </a>
                                        </li>';
                            }
                        }

                     $html .= '<li>
                                    <a href="#" class="print-invoice" data-href="'.route('sell.printInvoice', [$row->id]).'"><i class="fas fa-print" aria-hidden="true"></i>'.__('messages.print').'</a>
                                </li>';

                     if (config('constants.enable_download_pdf')) {
                            $sub_status = $row->sub_status == 'proforma' ? 'proforma' : '';
                            $html .= '<li>
                                        <a href="'.route('quotation.downloadPdf', ['id' => $row->id, 'sub_status' => $sub_status]).'" target="_blank">
                                            <i class="fas fa-print" aria-hidden="true"></i>'.__('lang_v1.download_pdf').'
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

                    if (auth()->user()->can('draft.delete') || auth()->user()->can('quotation.delete')) {
                        $html .= '<li>
                                <a href="'.action([\Modules\Licitacion\Http\Controllers\LicitacionController::class, 'destroy'], [$row->id]).'" class="delete-sale"><i class="fas fa-trash"></i>'.__('messages.delete').'</a>
                                </li>';
                    }

                    $html .= '</ul></div>';

                    return $html;
                 })
            ->rawColumns(['action'])
            ->make(true);
    }
    
}
