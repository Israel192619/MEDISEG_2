<?php

namespace Modules\Licitacion\Http\Controllers;

use App\Utils\ModuleUtil;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Menu;

class DataController extends Controller
{
    public function superadmin_package()
    {
        return [
            [
                'name' => 'tender_module',
                'label' => __('licitacion::lang.tender_module'),
                'default' => false,
            ],
        ];
    }

    public function modifyAdminMenu()
    {
        $business_id = session()->get('user.business_id');
        $module_util = new ModuleUtil();
        $is_tender_enabled = (bool) $module_util->hasThePermissionInSubscription(
            $business_id,
            'tender_module'
        );

        $background_color = '';
        if (config('app.env') == 'demo') {
            $background_color = '#bc8f8f !important';
        }

        if (
            $is_tender_enabled &&
            (auth()->user()->can('superadmin') ||
                auth()->user()->can('tender.view') ||
                auth()->user()->can('job_sheet.view_assigned') ||
                auth()->user()->can('job_sheet.view_all'))
        ) {
            Menu::modify('admin-sidebar-menu', function ($menu) use ($background_color) {
                $menu
                    ->dropdown(
                        __('licitacion::lang.tender'),

                        function ($sub) {
                            if (auth()->user()->can('licitacion.view')) {
                                $sub->url(
                                    action([
                                        \Modules\Licitacion\Http\Controllers\LicitacionController::class,
                                        'index',
                                    ]),
                                    __('licitacion::lang.tender_list'),
                                    [
                                        'icon' => '',
                                        'active' =>
                                            request()->segment(1) == 'licitacion' &&
                                            request()->segment(2) == 'licitaciones' &&
                                            request()->segment(3) == '',
                                    ]
                                );
                            }
                            if (auth()->user()->can('licitacion.create')) {
                                $sub->url(
                                    action([
                                        \Modules\Licitacion\Http\Controllers\LicitacionController::class,
                                        'create',
                                    ]),
                                    __('licitacion::lang.create_tender'),
                                    [
                                        'icon' => '',
                                        'active' =>
                                            request()->segment(1) == 'licitacion' &&
                                            request()->segment(2) == 'licitaciones' &&
                                            request()->segment(3) == 'create',
                                    ]
                                );
                            }
                        },

                        [
                            'icon' => 'fab fa-pushed',
                            'active' => request()->segment(1) == 'tender',
                            'style' => 'background-color:' . $background_color,
                        ]
                        /* action([\Modules\Licitacion\Http\Controllers\DashboardController::class, 'index']),
                            __('licitacion::lang.tender'),
                            ['icon' => 'fa fas fa-file-contract', 'active' => request()->segment(1) == 'tender', 'style' => 'background-color:'.$background_color] */
                    )
                    ->order(24);
            });
        }
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('licitacion::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('licitacion::create');
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
        return view('licitacion::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('licitacion::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
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
}
