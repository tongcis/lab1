<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoomController extends Controller
{
    public function index()
    {
        $items = Room::get();
        return view('pages.room.index', compact('items'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
            ],
        );

        if ($validator->fails()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            try {
                Room::updateOrCreate(
                    [
                        'id' => $request->id
                    ],
                    [
                        'name' => $request->name,
                    ]
                );

                return response()->json(['status' => 1, 'message' => 'Data Berhasil Disimpan.']);
            } catch (\Exception $e) {

                return response()->json(['status' => 0, 'error' => $e->getMessage()]);
            }
        }
    }

    public function show($id)
    {
        $data = Room::find($id);
        return response()->json($data);
    }

    public function edit($id)
    {
        $data = Room::find($id);
        return response()->json($data);
    }

    public function destroy($id)
    {
        $data = Room::find($id);
        $data->delete();
        return response()->json(['success' => 'Data Berhasil Dihapus.']);
    }
}
