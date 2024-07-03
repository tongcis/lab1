<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class InventoryController extends Controller
{
    public function index()
    {
        $items = Inventory::get();

        $rooms = Room::get();
        return view('pages.inventory.index', compact('items', 'rooms'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'room_id' => 'required',
                'name' => 'required',
                'amount' => 'required',
            ],
        );

        if ($validator->fails()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            try {
                $dt = Inventory::updateOrCreate(
                    [
                        'id' => $request->id
                    ],
                    [
                        'room_id' => $request->room_id,
                        'name' => $request->name,
                        'amount' => $request->amount,
                        'description' => $request->description,
                    ]
                );

                if ($request->hasFile('image')) {
                    if ($dt->image_url) {
                        Storage::delete('public/' . $dt->image_url);
                    }
                    $imagePath = 'inventories/' . $dt->id . '/' . Str::uuid()->toString() . '.' . $request->image->extension();
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
        $data = Inventory::with('room')->find($id);
        return response()->json($data);
    }

    public function edit($id)
    {
        $data = Inventory::find($id);
        return response()->json($data);
    }

    public function destroy($id)
    {
        $data = Inventory::find($id);
        $data->delete();
        return response()->json(['success' => 'Data Berhasil Dihapus.']);
    }
}
