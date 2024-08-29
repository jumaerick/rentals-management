<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Company;
use App\Models\RoomAssignment;
use App\Models\Room;
use Illuminate\Http\Request;
use App\Http\Requests\PropertyRequest;

class PropertyController extends Controller
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
         return view('property.create')->with(['companies'=>$companies]);
     }


     public function rooms(Request $request){
        $rooms = Room::where('property_id', $request->id)->whereNotIn('id', RoomAssignment::where('status', 1)->pluck('room_id')->toArray())->get();

        // $rooms = Property::find($id)->room;

        // dd($rooms);
        // foreach ($properties as $property){

        //     dd($property->room);
        // }

        return response()->json($rooms);
     }


    public function index()
    {
        //
        $properties = Property::all();
        

        return view('property.index')->with(['properties'=>$properties, 'company' =>'All Companies']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PropertyRequest $request)
    {
        //
        Property::create($request->validated());
        return back()->with('message', 'Property added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function show(Property $property)
    {
        //

        $rooms = $property->room;

        return view('room.index')->with(['rooms'=>$rooms, 'property'=>$property->name]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Property $property)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function destroy(Property $property)
    {
        //
    }
}
