<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Room;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $room = $request->input('room');
        $items = Inventory::when($room, function ($query, $room) {
            return $query->where('room_id', $room);
        })->get();

        $rooms = Room::get();

        return view('pages.user-pages.inventory.index', compact('items', 'rooms'));
    }
}
