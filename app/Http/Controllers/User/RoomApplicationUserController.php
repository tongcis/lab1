<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lecturer;
use App\Models\RoomApplication;
use App\Models\Room;
use App\Models\StudyProgram;
use App\Models\TypeOfRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoomApplicationUserController extends Controller
{
    public function index()
    {
        $items = RoomApplication::with('user', 'lecturer', 'room', 'typeRoom', 'course')->where('user_id', auth()->user()->id)->orderBy('date', 'desc')
            ->get();
        $student = auth()->user()->student;
        $rooms = Room::where('status', false)->get();
        $typeRooms = TypeOfRoom::get();
        $lecturers = Lecturer::where('position_id', 4)->get();
        $studyPrograms = StudyProgram::where('code', '!=', 1)->get();

        return view('pages.user-pages.room-application.index', compact('items', 'rooms', 'typeRooms', 'studyPrograms', 'lecturers'));
    }

    public function getCourse(Request $request)
    {
        $items = Course::where('study_program_id', $request->study_program_id)->get();
        return response()->json($items);
    }

    public function store(Request $request)
    {
        $type = TypeOfRoom::find($request->type_room_id);

        $validator = Validator::make(
            $request->all(),
            [
                'room_id' => 'required',
                'type_room_id' => 'required',
                'lecturer_id' => 'required',
                'course_id' => $type->is_learning == 1 ? 'required' : '',
                'activity_name' => $type->is_learning == 0 ? 'required' : '',
                'start_time' => 'required',
                'end_time' => 'required',
            ],
        );

        if ($validator->fails()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            try {

                $isAvailable = RoomApplication::where('room_id', $request->room_id)->where('date', $request->date)
                    ->where(function ($query) use ($request) {
                        $query->where('start_time', '<=', $request->start_time)
                            ->where('end_time', '>', $request->start_time)
                            ->orWhere('start_time', '<', $request->end_time)
                            ->where('end_time', '>=', $request->end_time)
                            ->orWhere(function ($q) use ($request) {
                                $q->where('start_time', '>=', $request->start_time)
                                    ->where('end_time', '<=', $request->end_time);
                            });
                    })
                    ->where('status', 2)
                    ->exists();

                if ($isAvailable) {
                    return response()->json(['status' => 2, 'message' => 'Ruangan pada jam dan tanggal yang diinput tidak tersedia']);
                } else {
                    RoomApplication::updateOrCreate(
                        [
                            'id' => $request->id
                        ],
                        [
                            'user_id' => auth()->user()->id,
                            'room_id' => $request->room_id,
                            'type_room_id' => $request->type_room_id,
                            'lecturer_id' => $request->lecturer_id,
                            'course_id' => $request->course_id,
                            'activity_name' => $request->activity_name,
                            'date' => now(),
                            'start_time' => $request->start_time,
                            'end_time' => $request->end_time,
                            'description' => $request->description,
                            'status' => 1
                        ]
                    );

                    return response()->json(['status' => 1, 'message' => 'Data berhasil disubmit.']);
                }
            } catch (\Exception $e) {

                return response()->json(['status' => 0, 'error' => $e->getMessage()]);
            }
        }
    }

    public function show($id)
    {
        $data = RoomApplication::with('user', 'lecturer', 'room', 'typeRoom', 'course', 'approvedBy', 'rejectedBy')->find($id);
        return response()->json($data);
    }

    public function edit($id)
    {
        $data = RoomApplication::with('typeRoom', 'course')->find($id);
        return response()->json($data);
    }
    public function destroy($id)
    {
        $data = RoomApplication::find($id);
        $data->delete();
        return response()->json(['success' => 'Data Berhasil Dihapus.']);
    }
}
