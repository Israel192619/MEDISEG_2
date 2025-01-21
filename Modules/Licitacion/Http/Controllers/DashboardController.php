<?php

namespace Modules\Licitacion\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Licitacion\Utils\LicitacionUtil;

class DashboardController extends Controller
{
    /**
     * All Utils instance.
     */
    protected $licitacionUtil;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(LicitacionUtil $licitacionUtil)
    {
        $this->licitacionUtil = $licitacionUtil;
    }
    
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        /* $business_id = request()->session()->get('user.business_id');
        $job_sheets_by_status = $this->licitacionUtil->getRepairByStatus($business_id);
        $job_sheets_by_service_staff = $this->licitacionUtil->getRepairByServiceStaff($business_id);
        $trending_brand_chart = $this->licitacionUtil->getTrendingRepairBrands($business_id);
        $trending_devices_chart = $this->licitacionUtil->getTrendingDevices($business_id);
        $trending_dm_chart = $this->licitacionUtil->getTrendingDeviceModels($business_id); */

        return view('licitacion::dashboard.index')
           /*  ->with(compact('job_sheets_by_status', 'job_sheets_by_service_staff', 'trending_devices_chart', 'trending_dm_chart', 'trending_brand_chart')) */;
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
