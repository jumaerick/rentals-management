<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Property;
use App\Models\Room;
use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;

class PaymentController extends Controller
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
        $rooms = Room::all();
        $users = User::all();
        $companies = Company::all();
        return view('payment.create')->with(['properties' => $properties,
         'rooms' => $rooms, 'users'=> $users, 'companies'=> $companies]);
    }

    public function index()
    {
        //
        $payments = Payment::with(['rent'])->get();

        return view('payment.index')->with(['payments'=> $payments, 'payment'=>'All Rent']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $data = $request->validate(
            [
                'room_id' => 'required',
                'amount' => 'required|numeric',
                'user_id'=> 'required',
                // 'payment_method' => 'required',
            ]

            );
        $payment = Payment::create($data);
        return back()->with('message', 'Payment added successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        //
    }

    public function edit($id)
    {
        //
        $payment = Payment::where('id', $id)->first();
        $properties = Property::all();
        $rooms = Room::all();
        return view('payment.edit')->with(['payment'=>$payment, 'properties'=> $properties, 
        'rooms'=> $rooms
    ]);
    }


    public function rooms(Request $request)
    {

        $rooms = Room::where('property_id', $request->id)->get();

        // $rooms = Property::find($id)->room;

        // dd($rooms);
        // foreach ($properties as $property){

        //     dd($property->room);
        // }

        return response()->json($rooms);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {


        $data = $request->validate(
            [
                'room_id' => 'required',
                'property_id' => 'required',
                'amount' => 'required',

            ]
        );
        $payment = Payment::where('id', $id)->first();

        // if ($property->property_code != $data['property_code']) {
        //     $findProperty = Property::where('property_code', $data['property_code'])->first();

        //     if ($findProperty) {
        //         return back()->withErrors([
        //             'property_code' => 'This property_code has already been taken.',
        //         ])->onlyInput('email');
        //     }
        // }

        $payment->room_id = $data['room_id'];
        // $payment->property_id = $data['property_id'];
        $payment->amount = $data['amount'];

        $payment->save();
        return redirect()->route('payment.index')->with('message', 'Details updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        Payment::find($request->id)->delete();
        return response()->json(['status' => true]);
    }
}
