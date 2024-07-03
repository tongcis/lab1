<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomApplication;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $rooms = Room::get();

        return view('pages.dashboard.index', compact('rooms'));
    }

    public function show($id)
    {
        $data = RoomApplication::with('user', 'lecturer', 'room', 'typeRoom', 'course', 'approvedBy', 'rejectedBy')->where('room_id', $id)->whereDate('date', now())->where('status', 2)->first();
        return response()->json($data);
    }
}
