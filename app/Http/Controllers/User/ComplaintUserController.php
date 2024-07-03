<?php

namespace App\Http\Controllers\User;

use App\Models\Room;
use App\Models\Complaint;
use App\Models\Inventory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ComplaintUserController extends Controller
{
    public function index()
    {

        $items = Complaint::with('reporter', 'user', 'inventory')
            ->where('reporter_id', auth()->user()->id)
            ->orderBy('date', 'desc')
            ->get();

        $rooms = Room::get();
        return view('pages.user-pages.complaint.index', compact('items', 'rooms'));
    }

    public function getInventory(Request $request)
    {
        $items = Inventory::where('room_id', $request->room_id)->get();
        return response()->json($items);
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'inventory_id' => 'required',
                'quantity' => 'required',
            ],
        );

        if ($validator->fails()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            try {
                $dt = Complaint::updateOrCreate(
                    [
                        'id' => $request->id
                    ],
                    [
                        'reporter_id' => auth()->user()->id,
                        'date' => now(),
                        'inventory_id' => $request->inventory_id,
                        'quantity' => $request->quantity,
                        'description' => $request->description,
                        'status' => 1
                    ]
                );

                if ($request->hasFile('image')) {
                    if ($dt->image_url) {
                        Storage::delete('public/' . $dt->image_url);
                    }
                    $imagePath = 'complaints/' . $dt->id . '/' . Str::uuid()->toString() . '.' . $request->image->extension();
                    $request->image->storeAs('public', $imagePath);
                    $dt->update(['image_url' => $imagePath]);
                }

                return response()->json(['status' => 1, 'message' => 'Data Berhasil Disimpan.']);
            } catch (\Exception $e) {

                return response()->json(['status' => 0, 'error' => $e->getMessage()]);
            }
        }
    }

    public function show($id)
    {
        $data = Complaint::with('reporter', 'user', 'inventory', 'inventory.room')->find($id);
        return response()->json($data);
    }

    public function edit($id)
    {
        $data = Complaint::find($id);
        return response()->json($data);
    }

    public function destroy($id)
    {
        $data = Complaint::find($id);
        $data->delete();
        return response()->json(['success' => 'Data Berhasil Dihapus.']);
    }
}
