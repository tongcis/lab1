<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudyProgram;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    public function index()
    {
        $items = Student::with('studyProgram')->get();

        $study_programs = StudyProgram::whereNotIn('name', ['Tim Laboran'])->get();
        return view('pages.student.index', compact('items', 'study_programs'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nim' => ['required', 'max:21', Rule::unique('students', 'nim')->ignore($request->id, 'id')],
                'name' => 'required',
                'email' => ['required', Rule::unique('users', 'email')->ignore($request->user_id, 'id')],
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
                $user = User::updateOrCreate(
                    [
                        'id' => $request->user_id
                    ],
                    [
                        'name' => $request->name,
                        'email' => $request->email,
                        'password' => Hash::make($request->nim)
                    ]
                );

                if ($request->id == null) {
                    $user->assignRole(Role::find([5]));
                }

                $user->student()->updateOrCreate(
                    [
                        'id' => $request->id
                    ],
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

                return response()->json(['status' => 1, 'message' => 'Data Berhasil Disimpan.']);
            } catch (\Exception $e) {
                DB::rollBack();

                return response()->json(['status' => 0, 'error' => $e->getMessage()]);
            }
        }
    }

    public function show($id)
    {
        $item = Student::with('studyProgram')->find($id);
        return response()->json($item);
    }

    public function edit($id)
    {
        $item = Student::with('studyProgram', 'user')->find($id);
        return response()->json($item);
    }

    public function destroy($id)
    {
        $item = Student::find($id);
        $user = User::find($item->user_id);
        if ($item) {
            $item->delete();
            $user->roles()->detach();
            $user->delete();

            return response()->json(['success' => 'Data Berhasil Dihapus.']);
        }
        return response()->json(['error' => 'Data Tidak Ditemukan.']);
    }
}
