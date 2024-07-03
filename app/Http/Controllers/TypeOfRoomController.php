<?php

namespace App\Http\Controllers;

use App\Models\TypeOfRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TypeOfRoomController extends Controller
{
    public function index()
    {
        $items = TypeOfRoom::get();
        return view('pages.type-of-room.index', compact('items'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'is_learning' => 'required'
            ],
        );

        if ($validator->fails()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            try {
                TypeOfRoom::updateOrCreate(
                    [
                        'id' => $request->id
                    ],
                    [
                        'name' => $request->name,
                        'is_learning' => $request->is_learning
                    ]
                );

                return response()->json(['status' => 1, 'message' => 'Data Berhasil Disimpan.']);
            } catch (\Exception $e) {

                return response()->json(['status' => 0, 'error' => $e->getMessage()]);
            }
        }
    }

    public function getData($id)
    {
        $data = TypeOfRoom::find($id);
        return response()->json($data);
    }

    public function edit($id)
    {
        $data = TypeOfRoom::find($id);
        return response()->json($data);
    }

    public function destroy($id)
    {
        $data = TypeOfRoom::find($id);
        $data->delete();
        return response()->json(['success' => 'Data Berhasil Dihapus.']);
    }
}
