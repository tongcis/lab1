<?php

namespace App\Http\Controllers\User;

use App\Models\Room;
use Illuminate\Http\Request;
use App\Models\RoomApplication;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $rooms = Room::get();

        return view('pages.user-pages.home.index', compact('rooms'));
    }
}
