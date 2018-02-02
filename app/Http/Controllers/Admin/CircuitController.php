<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Circuit;
use App\Country;

class CircuitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.circuit.index')->with( 'circuits', Circuit::paginate() );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.circuit.create')->with( 'countries', Country::all() );
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
			'name'			=> [ 'required', 'min:2', 'unique:circuits' ],
			'city'			=> [ 'required', 'min:2' ],
			'area'			=> [ 'nullable', 'min:2' ],
			'country_id'	=> [ 'required', 'integer', 'exists:countries,id' ],
        ]);
        
        $circuit = Circuit::create( $request->only( 'name', 'city', 'area', 'country_id' ) );
        
        return redirect()->route('admin.circuit.index')->with( 'success', __('The circuit :name has been added.', [ 'name' => $circuit->name ]) );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Circuit  $circuit
     * @return \Illuminate\Http\Response
     */
    public function show(Circuit $circuit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Circuit  $circuit
     * @return \Illuminate\Http\Response
     */
    public function edit(Circuit $circuit)
    {
        return view('admin.circuit.edit')->with( 'circuit', $circuit );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Circuit  $circuit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Circuit $circuit)
    {
        $request->validate([
			'name'		=> [ 'required', 'min:2', 'unique:circuits,name,' . $circuit->id ],
        ]);
        
        $circuit->update( $request->only( 'name', 'code' ) );
        
        return redirect()->route('admin.circuit.index')->with( 'success', __('The circuit :name has been updated.', [ 'name' => $circuit->name ]) );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Circuit  $circuit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Circuit $circuit)
    {
        //
    }
}
