<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Company;
use App\Models\Property;
use App\Http\Requests\RoomRequest;
use Illuminate\Http\Request;

class RoomController extends Controller
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
         return view('room.create')->with(['companies'=>$companies, 'properties'=>$properties]);
     }

    public function index()
    {
        //
        $properties = Property::all();

        return view('room.index')->with(['properties'=>$properties, 'company' =>'All Properties']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoomRequest $request)
    {
        //
        // dd($request);
        $room = Room::create($request->validated());
        return back()->with('message', 'Room added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function show(Room $room)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Room $room)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function destroy(Room $room)
    {
        //
    }
}
