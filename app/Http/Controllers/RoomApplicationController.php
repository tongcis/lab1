<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lecturer;
use App\Models\RoomApplication;
use App\Models\Room;
use App\Models\TypeOfRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class RoomApplicationController extends Controller
{
    public function index()
    {
        $items = RoomApplication::with('user', 'lecturer', 'room', 'typeRoom', 'course')->orderBy('date', 'desc')
            ->get();

        $rooms = Room::get();
        $typeRooms = TypeOfRoom::get();
        $courses = Course::get();
        $lecturers = Lecturer::get();

        return view('pages.room-application.index', compact('items', 'rooms', 'typeRooms', 'courses', 'lecturers'));
    }

    public function schedule(Request $request)
    {
        $date = now()->format('Y-m-d');

        if ($request->date) {
            $date = $request->date;
        }

        $schedule = RoomApplication::with('user', 'room', 'approvedBy')->where('date', $date)->where('status', 4)->orderBy('start_time', 'asc')->get()->groupBy('room.name');

        return view('pages.room-application.schedule', compact('schedule', 'date'));
    }

    public function show($id)
    {
        $data = RoomApplication::with('user', 'lecturer', 'room', 'typeRoom', 'course', 'approvedBy', 'rejectedBy')->find($id);
        return response()->json($data);
    }

    public function edit($id)
    {
        $data = RoomApplication::with('typeRoom')->find($id);
        return response()->json($data);
    }
    public function approve($id)
    {
        $roomApplication = RoomApplication::find($id);
        $start_time = $roomApplication->start_time;
        $end_time = $roomApplication->end_time;
        RoomApplication::where('date', $roomApplication->date)
            ->where(function ($query) use ($start_time, $end_time) {
                $query->whereBetween('start_time', [$start_time, $end_time])
                    ->orWhereBetween('end_time', [$start_time, $end_time]);
            })
            ->where('room_id', $roomApplication->room_id)
            ->where('status', 1)
            ->update([
                'status' => 3,
                'rejected_at' => Carbon::now(),
                'rejected_by' => auth()->user()->id,
                'rejected_note' => 'Jadwal sudah ada.'
            ]);

        if ($roomApplication) {
            $roomApplication->update([
                'status' => 2,
                'approved_by' => auth()->user()->id,
                'approved_at' => Carbon::now(),
                'rejected_at' => null,
                'rejected_by' => null,
                'rejected_note' => null
            ]);
            Room::find($roomApplication->room_id)->update(['status' => true]);
            return response()->json(['success' => 'Pengajuan berhasil diapprove.']);
        }
    }

    public function reject(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'rejected_note' => 'required',
            ],
        );

        if ($validator->fails()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            $RoomApplication = RoomApplication::find($request->id);
            if ($RoomApplication) {
                $RoomApplication->update([
                    'status' => 3,
                    'rejected_by' => auth()->user()->id,
                    'rejected_at' => now(),
                    'rejected_note' => $request->rejected_note
                ]);
                return response()->json(['status' => 1, 'message' => 'Pengajuan telah ditolak.']);
            }
        }
    }

    public function report()
    {
        $rooms = Room::all();
        return view('pages.room-application.report', compact('rooms'));
    }

    public function export(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'room' => 'required'
        ]);

        $query = RoomApplication::whereIn('status', [2, 4])->whereBetween('date', [$request->start_date, $request->end_date]);

        if ($request->room != 'all') {
            $query->where('room_id', $request->room);
        }

        $data['items'] = $query->get();

        $data['start_date'] = $request->start_date;
        $data['end_date'] = $request->end_date;

        $pdf = \PDF::loadView('pages.room-application.print', ['data' => $data]);
        $pdf->setPaper('a4', 'landscape');
        return $pdf->stream();
    }
}
