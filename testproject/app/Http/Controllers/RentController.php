<?php

namespace App\Http\Controllers;

use App\Models\Rent;
use App\Models\Company;
use App\Models\Property;
use App\Models\Room;
use App\Models\RoomAssignment;
use Illuminate\Http\Request;
use App\Http\Requests\RentRequest;
use Illuminate\Support\Carbon;

class RentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        //
        $companies = Company::all();
        $properties = Property::all();
        $rooms = Room::all();
        return view('rent.create')->with(['companies' => $companies, 'properties' => $properties, 'rooms'=> $rooms]);
    }


    public function index()
    {
        //
        $rooms = Room::with(['rent'])->get();

        // dd($rooms);
        return view('rent.index')->with(['rooms'=> $rooms, 'property'=>'All properties']);
    }

    public function rentListing()
    {
        //
        $rooms = RoomAssignment::where('status', 1)->get();

        // dd($rooms);
        return view('rent.listing')->with(['rooms'=> $rooms, 'property'=>'All properties']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RentRequest $request)
    {
        //
        $rent = Rent::create($request->validated());
        return back()->with('message', 'Company added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rent  $rent
     * @return \Illuminate\Http\Response
     */
    public function show(Rent $rent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Rent  $rent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rent $rent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rent  $rent
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rent $rent)
    {
        //
    }
}
