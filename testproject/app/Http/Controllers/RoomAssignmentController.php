<?php

namespace App\Http\Controllers;

use App\Models\RoomAssignment;
use App\Models\Property;
use App\Models\Room;
use App\Models\User;
use App\Models\Rent;
use App\Models\Payment;
use App\Http\Requests\RoomAssignmentRequest;
use Illuminate\Http\Request;
use DB;

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
        $rooms = Room::whereNotIn('id', RoomAssignment::where('status', 1)->pluck('room_id')->toArray())->get();
        $users = User::all();
        return view('roomAssignment.create')->with(['properties' => $properties, 'rooms' => $rooms, 'users' => $users]);
    }

    public function index()
    {
        //
        $roomAssignments = RoomAssignment::with(['room'])::select('user_id', DB::raw('SUM(amount) as total_amount'))
        ->groupBy('user_id')
        ->get();

        dd($roomAssignments);
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
        // dd($request);
        $userRequest = $request->validated();
        $roomAssignment = RoomAssignment::create($request->validated());

        return back()->with('message', 'Room Assignment Submitted successfully');
    }

    public function changeStatus(Request $request)
    {
        //
        $roomAssignment = RoomAssignment::find($request->id);

        $payments = Payment::where('user_id', $roomAssignment->user->id)->where('room_id', $roomAssignment->room_id)->get();
        $totalPaid = array_sum($payments->pluck('amount')->toArray());
        $deposit = array_sum(Rent::where('room_id', $roomAssignment->room_id)->pluck('deposit')->toArray());
        $amount = array_sum(Rent::where('room_id', $roomAssignment->room_id)->pluck('amount')->toArray());
        $totalBilled = $deposit + $amount;

        if($totalBilled > $totalPaid){
            return response()->json(['status'=>false]);
            return back()->with('message', 'Cannot approve, there is a pending balance');
        }

        else {
            $roomAssignment->status = 1;
            $roomAssignment->save();
            return response()->json(['status'=>true]);
        }
        



        // return back()->with('message', 'Room assigned successfully');
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
