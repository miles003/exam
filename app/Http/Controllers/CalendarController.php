<?php

namespace App\Http\Controllers;

use App\Models\Calendar;
use Illuminate\Http\Request;
use App\Http\Repositories\getDesiredDateRepository;
use App\Http\Requests\CalendarRequest;

class CalendarController extends Controller
{
    /**
     * Constructor for getDesiredDateRepository
     *
     * @var [type]
     */
    private $getDesiredDateRepository;

    public function __construct(getDesiredDateRepository $getDesiredDateRepository)
    {
        $this->getDesiredDateRepository = $getDesiredDateRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Calendar::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\CalendarRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CalendarRequest $request)
    {
        $date = $this->getDesiredDateRepository->_getDate($request->event, $request->weeks, $request->from, $request->to);
        Calendar::insert($date);
        return $date;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Calendar  $calendar
     * @return \Illuminate\Http\Response
     */
    public function show(Calendar $calendar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Calendar  $calendar
     * @return \Illuminate\Http\Response
     */
    public function edit(Calendar $calendar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Calendar  $calendar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Calendar $calendar)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Calendar  $calendar
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        return Calendar::getQuery()->delete();
    }
}
