<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Support\Str;
use App\Models\StudyProgram;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index($id)
    {
        $user = User::find($id);
        $study_programs = StudyProgram::whereNotIn('name', ['Tim Laboran'])->get();
        if (auth()->user()->hasRole('Student')) {
            return view('pages.user-pages.profile.index-student', compact('user', 'study_programs'));
        }
        if (auth()->user()->hasRole('Lecturer')) {
            return view('pages.user-pages.profile.index-lecturer', compact('user', 'study_programs'));
        }
    }

    public function edit($id)
    {
        $data = User::with('student', 'student.studyProgram')->find($id);
        return response()->json($data);
    }

    public function editLecturer($id)
    {
        $data = User::with('lecturer', 'lecturer.studyProgram')->find($id);
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nim' => ['required', 'max:21', Rule::unique('students', 'nim')->ignore($request->student_id, 'id')],
                'name' => 'required',
                'email' => ['required', Rule::unique('users', 'email')->ignore($request->id, 'id')],
                'gender' => 'required',
                'address' => 'required',
                'phone' => 'required|max:13',
                'study_program_id' => 'required',
            ],
        );

        if ($validator->fails()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            DB::beginTransaction();

            try {
                $user = User::find($request->id);
                $user->update(
                    [
                        'name' => $request->name,
                        'email' => $request->email,
                    ]
                );

                $user->student()->update(
                    [
                        'nim' => $request->nim,
                        'name' => $request->name,
                        'email' => $request->email,
                        'gender' => $request->gender,
                        'address' => $request->address,
                        'phone' => $request->phone,
                        'study_program_id' => $request->study_program_id,
                    ]
                );

                if ($request->hasFile('photo')) {
                    if ($user->student->photo) {
                        Storage::delete('public/' . $user->student->photo);
                    }
                    $photoPath = 'photo_students/' . $user->id . '/' . Str::uuid()->toString() . '.' . $request->photo->extension();
                    $request->photo->storeAs('public', $photoPath);
                    $user->student->update(['photo' => $photoPath]);
                }

                DB::commit();

                return response()->json(['status' => 1, 'message' => 'Profil Berhasil Diubah.']);
            } catch (\Exception $e) {
                DB::rollBack();

                return response()->json(['status' => 0, 'error' => $e->getMessage()]);
            }
        }
    }

    public function storeLecturer(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nis' => ['required', 'max:21', Rule::unique('lecturers', 'nis')->ignore($request->lecturer_id, 'id')],
                'name' => 'required',
                'email' => ['required', Rule::unique('users', 'email')->ignore($request->id, 'id')],
                'gender' => 'required',
                'address' => 'required',
                'phone' => 'required|max:13',
                'study_program_id' => 'required',
            ],
        );

        if ($validator->fails()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            DB::beginTransaction();

            try {
                $user = User::find($request->id);
                $user->update(
                    [
                        'name' => $request->name,
                        'email' => $request->email,
                    ]
                );

                $user->lecturer()->update(
                    [
                        'nis' => $request->nis,
                        'name' => $request->name,
                        'email' => $request->email,
                        'gender' => $request->gender,
                        'address' => $request->address,
                        'phone' => $request->phone,
                        'study_program_id' => $request->study_program_id,
                    ]
                );

                if ($request->hasFile('photo')) {
                    if ($user->lecturer->photo) {
                        Storage::delete('public/' . $user->lecturer->photo);
                    }
                    $photoPath = 'photo_lecturers/' . $user->id . '/' . Str::uuid()->toString() . '.' . $request->photo->extension();
                    $request->photo->storeAs('public', $photoPath);
                    $user->lecturer->update(['photo' => $photoPath]);
                }

                DB::commit();

                return response()->json(['status' => 1, 'message' => 'Profil Berhasil Diubah.']);
            } catch (\Exception $e) {
                DB::rollBack();

                return response()->json(['status' => 0, 'error' => $e->getMessage()]);
            }
        }
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'password' => 'required|string|min:6|confirmed',
            ]
        );
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            $user = User::find($request->user_id);
            $user->update([
                'password' => Hash::make($request->password)
            ]);
            auth()->logout();
            return response()->json(['status' => 1, 'message' => 'Password Berhasil Diubah.']);
        }
    }
}
