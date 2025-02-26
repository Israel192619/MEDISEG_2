<?php

namespace Modules\Licitacion\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Licitacion\Entities\impuestosLicitacion;
use Modules\Licitacion\Entities\Licitaciones;
use Yajra\DataTables\Facades\DataTables;

class TaxController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('licitacion::impuestos.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('licitacion::createtax');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('licitacion::showtax');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $licitacion = impuestosLicitacion::find($id);
        return view('licitacion::impuestos.edit')->with(compact('licitacion'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //dd($request->all());
        $impuestos = impuestosLicitacion::find($id);
        $impuestos->update($request->all());
        $output = ['success' => 1,
                'msg' => 'Impuestos Actualizados',
            ];
        return redirect()->route('impuestos.index')->with('status', $output);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }


    
    public function getTaxes(){

        $business_id = request()->session()->get('user.business_id');

        $licitacion = impuestosLicitacion::get();

        return Datatables::of($licitacion)
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
                                        <a  href="' .
                        action(
                            [
                                \Modules\Licitacion\Http\Controllers\TaxController::class,
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

           

            $html .= '</ul></div>';

            return $html;
        })
            ->rawColumns(['action'])
            ->make(true);

    }
}
