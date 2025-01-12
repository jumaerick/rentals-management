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
        $rents = Rent::all();

        // dd($rooms);
        return view('rent.index')->with(['rents'=> $rents, 'property'=>'All properties']);
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
        return back()->with('message', 'Rent added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rent  $rent
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        //
        $rent = Rent::where('id', $id)->with(['room'])->first();
        return response()->json($rent);
    }


    public function deposit(Request $request, $id)
    {
        //
        $rent = Rent::where('room_id', $request->id)->with(['room'])->first();
        $deposit = $rent ? $rent->deposit : false;
        $amount = $rent ? $rent->amount : false;
        return response()->json(['deposit'=>$deposit, 'amount'=>$amount]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Rent  $rent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $data = $request->validate(
            [
                'property_id' => 'required',
                'room_id' => 'required',
                'amount' => 'required|numeric',
                'deposit' => 'required|numeric',
                'rent_date' => 'required|date',

            ]
        );

        $rent = Rent::where('id', $id)->first();

        // $rent->property_id = $data['property_id'];
        $rent->room_id = $data['room_id'];
        $rent->amount = $data['amount'];
        $rent->deposit = $data['deposit'];
        $rent->rent_date = $data['rent_date'];
        $rent->save();

        return redirect()->route('rent.index')->with(['message'=> 'Rent details updated successfully']);


    }

    public function edit($id)
    {
        //

        $rents = Rent::where('id', $id)->first();
        $properties = Property::all();
        $rooms = Room::all();
        return view('rent.edit')->with(['rents'=>$rents, 'properties'=> $properties, 
        'rooms'=> $rooms
    ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rent  $rent
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Rent::find($request->id)->delete();
        return response()->json(['status' => true]);

        //
    }
}
