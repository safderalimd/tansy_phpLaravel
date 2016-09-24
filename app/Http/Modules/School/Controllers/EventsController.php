<?php

namespace App\Http\Modules\School\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Modules\School\Models\Events;
use App\Http\Modules\School\Requests\EventsFormRequest;
use Carbon\Carbon;

class EventsController extends Controller
{
    /**
     * Instantiate a new Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('screen:' . Events::screenId());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if (is_null($request->input('st')) && is_null($request->input('en'))) {
            $start = Carbon::now()->subDays(7)->toDateString();
            $end = Carbon::now()->addDays(1)->toDateString();
            return redirect('/cabinet/events?st='.$start.'&en='.$end);
        }

        $events = new Events($request->input());
        return view('modules.school.Events.list', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $events = new Events;
        return view('modules.school.Events.form', compact('events'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param EventsFormRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(EventsFormRequest $request)
    {
        $events = new Events($request->input());
        $events->save();
        flash('Event Added!');
        return redirect('/cabinet/events'.query_string());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $events = new Events;
        $events->setDetail($id);
        return view('modules.school.Events.form', compact('events'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param EventsFormRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(EventsFormRequest $request, $id)
    {
        $events = new Events($request->input());
        $events->setAttribute('event_id', $id);
        $events->update();
        flash('Event Updated!');
        return redirect('/cabinet/events'.query_string());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $events = new Events($request->input());
        $events->setAttribute('event_id', $id);
        $events->delete();
        flash('Event Deleted!');
        return redirect('/cabinet/events'.query_string());
    }
}
