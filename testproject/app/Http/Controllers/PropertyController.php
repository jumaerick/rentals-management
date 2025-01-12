<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Company;
use App\Models\RoomAssignment;
use App\Models\Room;
use App\Models\User;
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
        return view('property.create')->with(['companies' => $companies]);
    }


    public function rooms(Request $request)
    {

        $rooms = Room::where('property_id', $request->id)->whereNotIn('id', RoomAssignment::where('status', 1)->pluck('room_id')->toArray())->get();

        // $rooms = Property::find($id)->room;

        // dd($rooms);
        // foreach ($properties as $property){

        //     dd($property->room);
        // }

        return response()->json($rooms);
    }


    public function edit($id)
    {
        //
        $property = Property::where('id', $id)->first();
        $companies = Company::all();
        return view('property.edit')->with(['property' => $property, 'companies' => $companies, 'cid' => $property->company_id]);
    }

    public function index()
    {
        //
        return view('property.index', [
            'properties' => Property::Paginate(5),
            'company' => 'All Companies'
        ]);


        // return view('property.index')->with(['properties'=>$properties, 'company' =>'All Companies']);
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

        $data = $request->validate ([
            'name'=>'required|min:5',
            'location' =>'required',
            'property_code'=>'required|unique:properties',
            'company_id' =>'required',
        ]);

        Property::create($data);
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

        // $rooms = $property->room;

        $rooms  = Room::where('property_id', $property->id)->paginate(5);

        return view(
            'room.index',
            [
                'rooms' => $rooms,
                'property' => $property->name
            ]
        );

        // return view('room.index')->with(['rooms'=>$rooms, 'property'=>$property->name]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //


        $data = $request->validate(
            [
                'name' => 'required',
                'company_id' => 'required',
                'property_code' => 'required',
                'location' => 'required',

            ]
        );
        $property = Property::where('id', $id)->first();

        if ($property->property_code != $data['property_code']) {
            $findProperty = Property::where('property_code', $data['property_code'])->first();

            if ($findProperty) {
                return back()->withErrors([
                    'property_code' => 'This property_code has already been taken.',
                ])->onlyInput('email');
            }
        }

        $property->name = $data['name'];
        $property->property_code = $data['property_code'];
        $property->company_id = $data['company_id'];
        $property->location = $data['location'];

        $property->save();
        return redirect()->route('property.index')->with('message', 'Details updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        Property::find($request->id)->delete();
        return redirect()->route('property.list');
    }
}
