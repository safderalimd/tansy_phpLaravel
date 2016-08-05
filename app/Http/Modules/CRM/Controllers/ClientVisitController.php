<?php

namespace App\Http\Modules\CRM\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\CRM\Models\ClientVisit;
use App\Http\Modules\CRM\Models\ClientVisitDetail;
use App\Http\Modules\CRM\Requests\ClientVisitEditFormRequest;
use App\Http\Modules\CRM\Requests\ClientVisitCreateFormRequest;

class ClientVisitController extends Controller
{
    /**
     * Instantiate a new Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('screen:' . ClientVisit::screenId(), ['only' => [
            'index',
            'create',
            'store',
        ]]);

        $this->middleware('screen:' . ClientVisitDetail::screenId(), ['only' => [
            'detail',
        ]]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $client = new ClientVisit;
        $client->loadData();
        return view('modules.crm.ClientVisit.create', compact('client'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ClientVisitCreateFormRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientVisitCreateFormRequest $request)
    {
        $input = $request->input();
        $input['organization_city_area'] = $request->input('organization_city_area_new');
        $input['facility_city_area'] = $request->input('facility_city_area_new');

        $client = new ClientVisit($input);
        $client->setFlags();

        $client->save();
        flash('Client Visit Added!');
        return redirect('/cabinet/client-visit');
    }

    public function detail(Request $request)
    {
        $client = ClientVisitDetail::findOrFail($request->input('id'));
        return view('modules.crm.ClientVisit.detail', compact('client'));
    }
}
