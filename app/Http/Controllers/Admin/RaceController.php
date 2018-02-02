<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Rules\IsRaceNameUnique;

use App\Circuit;
use App\Season;
use App\Race;

class RaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		$season = $request->input('season') ? Season::find( $request->input('season') ) : ( Season::first() ?: new Season );
		
        return view('admin.race.index')->with([
			'currentSeason'	=> $season,
			'seasons'		=> Season::all(),
			'races'			=> Race::bySeason($season)->paginate(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
		$request->validate([
			'season'	=> [ 'required', 'integer', 'exists:seasons,id' ],
		]);
		
		return view('admin.race.create')->with([
			'season'	=> Season::findOrFail( $request->input('season') ),
			'circuits'	=> Circuit::all(),
		]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
			'season_id'		=> [ 'required', 'integer', 'exists:seasons,id' ],
			'start_time'	=> [ 'required', 'date_format:Y-m-d H:i:s' ],
			'name'			=> [ 'required', 'min:5', new IsRaceNameUnique( $request->input('season_id'), $request->input('start_time') ) ],
			'circuit_id'	=> [ 'required', 'integer', 'exists:circuits,id' ],
        ]);
        
        $race = Race::create( $request->only( 'season_id', 'start_time', 'name', 'circuit_id' ) );
        
        return redirect()->route('admin.race.index', [ 'season' => $race->season_id ])->with( 'success', __('The race :name has been added.', [ 'name' => $race->name ]) );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Race  $race
     * @return \Illuminate\Http\Response
     */
    public function show(Race $race)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Race  $race
     * @return \Illuminate\Http\Response
     */
    public function edit(Race $race)
    {
        return view('admin.race.edit')->with([
			'race'		=> $race,
			'circuits'	=> Circuit::all(),
		]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Race  $race
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Race $race)
    {
        $request->validate([
			'season_id'		=> [ 'required', 'integer', 'exists:seasons,id' ],
			'start_time'	=> [ 'required', 'date_format:Y-m-d H:i:s' ],
			'name'			=> [ 'required', 'min:5', new IsRaceNameUnique( $request->input('season_id'), $request->input('start_time'), $race->id ) ],
			'circuit_id'	=> [ 'required', 'integer', 'exists:circuits,id' ],
        ]);
        
        $race->update( $request->only( 'season_id', 'start_time', 'name', 'circuit_id' ) );
        
        return redirect()->route('admin.race.index', [ 'season' => $race->season_id ])->with( 'success', __('The race :name has been changed.', [ 'name' => $race->name ]) );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Race  $race
     * @return \Illuminate\Http\Response
     */
    public function destroy(Race $race)
    {
        //
    }
}