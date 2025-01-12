<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Company;
use App\Models\Property;
use App\Http\Requests\RoomRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;
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
        return view('room.create')->with(['companies' => $companies, 'properties' => $properties]);
    }



    public function index()
    {
        //
        // $rooms = Room::all();



        return view(
            'room.index',
            [
                'rooms' => Room::paginate(5),
                'property' => 'All Properties'
            ]
        );
    }

    public function edit($id)
    {
        //
        $room = Room::where('id', $id)->first();
        return view('room.edit')->with(['room' => $room]);
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
    public function show(Request $request, $id)
    {
        //
        $room = Room::join('properties', 'rooms.property_id', '=', 'properties.id')
            ->select('properties.name', 'rooms.id', 'rooms.room_code')
            ->where('rooms.id', $id)->first();
        // dd($room);

        return $room;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //

        $data = $request->validate(
            [
                'property_id' => 'required',
                'room_code' => 'required',
            ]
        );

        $room = Room::where('id', $id)->first();

        if ($room->room_code != $data['room_code']) {
            $findRoom = Room::where('room_code', $data['room_code'])->where('property_id', $data['property_id'])->first();
            if ($findRoom) {
                return back()->withErrors([
                    'room_code' => 'The room_code already exists',
                ])->onlyInput('room_code');
            }
        }

        $room->room_code = $data['room_code'];
        $room->save();
        return redirect()->route('room.index')->with('message', 'Details updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        // dd($request);
        Room::find($request->id)->delete();
        return redirect()->route('room.list');
    }
}
