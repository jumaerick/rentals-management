<?php

namespace App\Http\Controllers;

use App\Models\Rent;
use App\Models\Company;
use App\Models\Property;
use App\Models\Room;
use App\Models\Payment;
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
        return view('rent.create')->with(['companies' => $companies, 'properties' => $properties, 'rooms' => $rooms]);
    }


    public function index()
    {
        //
        $rooms = Room::with(['rent'])->get();

        // dd($rooms);
        return view('rent.index')->with(['rooms' => $rooms, 'property' => 'All properties']);
    }

    public function rentListing()
    {

        $records = RoomAssignment::select('id', 'user_id', 'room_id', 'status','updated_at')->where('status', 1)->distinct()->get();


        $records = $records->map(function ($record) {
            $totalAmount = Payment::where('user_id', $record->user_id)
                ->where('room_id', $record->room_id)
                ->pluck('amount')
                ->sum();

            $at = Carbon::parse($record->updated_at)->format('Y-m'); 
            $cl = Carbon::now()->format('Y-m'); 

            $dateDiff = Carbon::parse($cl)->diffInMonths(Carbon::parse($at)) + 1; 
            $paid = $totalAmount;
            $billed = ($dateDiff * ($record->room->rent->amount) + ($record->room->rent->deposit));
            $balance = $paid - $billed;
            $record->amount = $totalAmount;
            $record->email = $record->user->email;
            $record->room_code = $record->room->room_code;
            $record->name = $record->room->property->name;
            $record->balance =  $record->name = $balance;


            return $record;
        });

        // dd($records);

        return view('rent.listing')->with(['rooms' => $records, 'property' => 'All properties']);
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
