<?php

namespace App\Http\Controllers;

use App\Models\RoomAssignment;
use App\Models\Property;
use App\Models\Room;
use App\Models\User;
use App\Models\Rent;
use App\Models\Payment;
use App\Http\Requests\RoomAssignmentRequest;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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
        $companies = Company::all();
        return view('roomAssignment.create')->with([
            'properties' => $properties,
            'rooms' => $rooms,
            'users' => $users,
            'companies' => $companies
        ]);
    }

    public function index()
    {


        $records = RoomAssignment::select('id', 'user_id', 'room_id', 'status', 'updated_at')->distinct()->get();

        foreach($records as $rec){
            $payments = array_sum(Payment::where('user_id', $rec->user_id)->where('room_id', $rec->room_id)->pluck('amount')->toArray());
            $deposit = Rent::where('room_id', $rec->room_id)->first();
            $amount = Rent::where('room_id', $rec->room_id)->first();
            $deposit = $deposit->deposit ?? 0;
            $amount = $amount->amount ?? 0;
            $rec->append('payment_status');
            $now =date_create(Carbon::now()->toDateTimeString());
            $end = $rec->updated_at;
            $interval = date_diff($now, $end);
            $months = $interval ->format('%m') + 1;
            $totalTodate = (($amount*$months)+$deposit);
            $bal = $payments - $totalTodate;
            $status = '';

            if ($bal > 0){
                $status = 'Overpaid';
            }
            elseif($bal < 0){
                $status = 'Pending';
            }

            elseif(($bal == 0) && ($deposit==0 || $amount)){
                $status = 'Inactive';
            }  
            else {
                $status = 'Cleared';
            }
            $rec->payment_status = $status;


        }


        $records = $records->map(function ($record) {
            $totalAmount = Payment::where('user_id', $record->user_id)
                ->where('room_id', $record->room_id)
                ->pluck('amount')
                ->sum();

            // Add the total amount to the record
            // dd($record->room->property->name);
            $record->amount = $totalAmount;
            $record->email = $record->user ? $record->user->email : '';
            $record->room_code = $record->room->room_code;
            $record->name = $record->room->property->name;


            return $record;
        });


        // Get the total payments for all records in one query
        // $paymentTotals = Payment::select('user_id', 'room_id', DB::raw('SUM(amount) as total_amount'))
        //     ->groupBy('user_id', 'room_id')
        //     ->get()
        //     ->mapWithKeys(function ($item) {
        //         // Create a unique key based on user_id and room_id
        //         $key = $item->user_id . '-' . $item->room_id;
        //         // Map the key to the total_amount
        //         return [$key => $item->total_amount];
        //     });

        // // Map the totals to the records
        // $records = RoomAssignment::with(['user', 'room.property'])
        //     ->select('user_id', 'room_id', 'status')
        //     ->distinct()
        //     ->get();

        // // Map the totals to the records
        // $records = $records->map(function ($record) use ($paymentTotals) {
        //     $key = $record->user_id . '-' . $record->room_id;
        //     $record->amount = $paymentTotals[$key] ?? 0; // Default to 0 if no payments
        //     $record->email = $record->user->email;
        //     $record->room_code = $record->room->room_code;
        //     $record->name = $record->room->property->name;
        //     return $record;
        // });

        return view('roomAssignment.index')->with(['roomAssignments' => $records]);
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
        $now =date_create(Carbon::now()->toDateTimeString());
        $roomAssignment = RoomAssignment::find($request->id);
        $end = $roomAssignment->updated_at;
        $interval = date_diff($now, $end);
        $months = $interval ->format('%m') + 1;
        $statuses = RoomAssignment::where('room_id', $roomAssignment->room_id)->pluck('status')->toArray();

        $payments = Payment::where('user_id', $roomAssignment->user->id)->where('room_id', $roomAssignment->room_id)->get();
        $totalPaid = array_sum($payments->pluck('amount')->toArray());
        $deposit = Rent::where('room_id', $roomAssignment->room_id)->first()->deposit;
        $amount = Rent::where('room_id', $roomAssignment->room_id)->first()->amount;
        $totalBilled = $deposit + $amount;

        if (($totalBilled > $totalPaid) &  ($roomAssignment->status == 0)) {
            return response()->json(['status' => false]);
            return back()->with('message', 'Cannot approve, there is a pending balance');
        } elseif (in_array(1, $statuses) && ($roomAssignment->status == 0)) {
            $roomAssignment->status = 2;
            $roomAssignment->save();
            return response()->json(['status' => "updated_status"]);
        } elseif (($totalPaid >= $totalBilled) &  ($roomAssignment->status == 0)) {
            $roomAssignment->status = 1;
            $roomAssignment->save();
            return response()->json(['status' => true]);
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

    public function edit($id)
    {
        //
        $properties = Property::all();
        $rooms = Room::all();
        $roomAssignment = RoomAssignment::where('id', $id)->first();
        return view('roomAssignment.edit')->with([
            'roomAssignment' => $roomAssignment,
            'properties' => $properties,
            'rooms' => $rooms
        ]);
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
    public function destroy(Request $request)
    {
        //

        RoomAssignment::find($request->id)->delete();
        return response()->json(['status' => true]);
    }
}
