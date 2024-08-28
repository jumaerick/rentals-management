<?php

namespace App\Http\Controllers;

use App\Models\RoomAssignment;
use App\Models\Property;
use App\Models\Room;
use App\Models\User;
use App\Models\Payment;
use App\Http\Requests\RoomAssignmentRequest;
use Illuminate\Http\Request;

class RoomAssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        //
        $properties = Property::all();
        $rooms = Room::whereNotIn('id', RoomAssignment::all()->pluck('room_id')->toArray())->get();

        $users = User::all();
        return view('roomAssignment.create')->with(['properties' => $properties, 'rooms' => $rooms, 'users' => $users]);
    }

    public function index()
    {
        //
        $roomAssignments = RoomAssignment::all();
        return view('roomAssignment.index')->with(['roomAssignments' => $roomAssignments]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoomAssignmentRequest $request)
    {
        //
        // dd($request->validated()['user_id']);
        $userRequest = $request->validated();
        $payments = Payment::where('user_id', $userRequest['user_id'])->where('room_id', $userRequest['room_id'])->get();
        dd($payments);
        
        $roomAssignment = RoomAssignment::create($request->validated());


        return back()->with('message', 'Room assigned successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RoomAssignment  $roomAssignment
     * @return \Illuminate\Http\Response
     */
    public function show(RoomAssignment $roomAssignment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RoomAssignment  $roomAssignment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RoomAssignment $roomAssignment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RoomAssignment  $roomAssignment
     * @return \Illuminate\Http\Response
     */
    public function destroy(RoomAssignment $roomAssignment)
    {
        //
    }
}
