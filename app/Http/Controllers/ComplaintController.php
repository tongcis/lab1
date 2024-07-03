<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\Inventory;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ComplaintController extends Controller
{
    public function index()
    {
        if (Auth::user()->hasRole("Super Admin") || Auth::user()->hasRole("Laboratory Team") || Auth::user()->hasRole("Leader")) {
            $items = Complaint::with('reporter', 'user', 'inventory')->orderBy('date', 'desc')->get();
        } else {
            $items = Complaint::with('reporter', 'user', 'inventory')->where('reporter_id', auth()->user()->id)->orderBy('date', 'desc')->get();
        }

        $inventories = Inventory::with('room')->get();
        return view('pages.complaint.index', compact('items', 'inventories'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'inventory_id' => 'required',
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

    public function followUp($id)
    {
        $complaint = Complaint::find($id);
        if ($complaint) {
            $complaint->update([
                'status' => 2,
                'user_id' => auth()->user()->id,
            ]);
            return response()->json(['success' => 'Data Berhasil Difollow up.']);
        }
    }

    public function done(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'note' => 'required',
            ],
        );

        if ($validator->fails()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            $complaint = Complaint::find($request->id);
            if ($complaint) {
                $complaint->update([
                    'status' => 3,
                    'note' => $request->note,
                    'follow_up_date' => now(),
                ]);
                if ($request->hasFile('image')) {
                    if ($complaint->attachment) {
                        Storage::delete('public/' . $complaint->attachment);
                    }
                    $imagePath = 'follow-ups/' . $complaint->id . '/' . Str::uuid()->toString() . '.' . $request->image->extension();
                    $request->image->storeAs('public', $imagePath);
                    $complaint->update(['attachment' => $imagePath]);
                }
                return response()->json(['status' => 1, 'message' => 'Data Berhasil Diselesaikan.']);
            }
        }
    }

    public function destroy($id)
    {
        $data = Complaint::find($id);
        $data->delete();
        return response()->json(['success' => 'Data Berhasil Dihapus.']);
    }

    public function report()
    {
        $rooms = Room::all();
        return view('pages.complaint.report', compact('rooms'));
    }

    public function export(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'room' => 'required'
        ]);

        $query = Complaint::whereBetween('date', [$request->start_date, $request->end_date]);

        if ($request->room != 'all') {
            $query->whereHas('inventory', function ($query) use ($request) {
                $query->where('room_id', $request->room);
            });
        }

        $data['items'] = $query->get();

        $data['room'] = $request->room != 'all' ? Room::find($request->room) : 'all';
        $data['start_date'] = $request->start_date;
        $data['end_date'] = $request->end_date;

        $pdf = \PDF::loadView('pages.complaint.print', ['data' => $data]);
        $pdf->setPaper('a4', 'landscape');
        return $pdf->stream();
    }
}
