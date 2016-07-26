<?php

namespace App\Http\Modules\System\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\System\Models\CustomFields;
use App\Http\Modules\System\Requests\CustomFieldsFormRequest;
use Illuminate\Http\Request;

class CustomFieldsController extends Controller
{
    /**
     * Instantiate a new Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('screen:' . CustomFields::screenId());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $fields = new CustomFields($request->input());
        return view('modules.system.CustomFields.list', compact('fields'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $fields = new CustomFields($request->input());
        return view('modules.system.CustomFields.form', compact('fields'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CustomFieldsFormRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomFieldsFormRequest $request)
    {
        $fields = new CustomFields;
        $fields->setAttribute('active', 0);
        $fields->setAttribute('mandatory_input', 0);
        $fields->setAttribute('visible_in_grid', 0);
        $fields->setAttribute('existing', 0);
        $fields->fill($request->input());
        $fields->saveField();
        flash('Custom Field Added!');
        return redirect('/cabinet/custom-fields?gsi='.$fields->gsi);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $fields = CustomFields::findOrFail($id);
        return view('modules.system.CustomFields.form', compact('fields'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CustomFieldsFormRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(CustomFieldsFormRequest $request, $id)
    {
        $fields = new CustomFields($request->input());
        $fields->setAttribute('custom_field_id', $id);
        $fields->update();
        flash('Custom Field Updated!');
        return redirect('/cabinet/custom-fields?gsi='.$fields->gsi);
    }
}
