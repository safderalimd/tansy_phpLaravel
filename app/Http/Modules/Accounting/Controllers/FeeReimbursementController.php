<?php

namespace App\Http\Modules\Accounting\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\Accounting\Models\FeeReimbursement;
use App\Http\Modules\Accounting\Requests\FeeReimbursementFormRequest;

class FeeReimbursementController extends Controller
{
    /**
     * Instantiate a new Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('screen:' . FeeReimbursement::screenId());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $reimbursement = new FeeReimbursement($request->input());
        return view('modules.accounting.FeeReimbursement.list', compact('reimbursement'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param FeeReimbursementFormRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(FeeReimbursementFormRequest $request)
    {
        $reimbursement = new FeeReimbursement($request->input());
        $reimbursement->update();
        flash('Fee Reimbursement Updated!');
        return redirect('/cabinet/fee-reimbursement');
    }

}
