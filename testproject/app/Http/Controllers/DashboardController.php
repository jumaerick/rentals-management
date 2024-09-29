<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use App\Models\Property;
use App\Models\Room;
use App\Models\RoomAssignment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //

    public function index()
    {
        // dd(RoomAssignment::where('status', 1)->get());
        return view('dashboard', [
            'users' => User::count(),
            'properties' => Property::count(),
            'companies' => Company::count(),
            'rooms' => Room::count(),
            'roomsAssigned' => RoomAssignment::where('status', 1)->count(),
            'roomsAvailable' => Room::wherenotin('id', RoomAssignment::where('status', 1)->pluck('room_id')->toArray())->count(),
            'roomsPendingAssignments' => RoomAssignment::where('status', 0)->count(),
        ]);
    }

}
