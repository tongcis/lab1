<?php

namespace App\Http\Controllers;

use App\Models\Lecturer;
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

class LecturerController extends Controller
{
    public function index()
    {
        $items = Lecturer::with('studyProgram');

        if (!auth()->user()->hasRole('Super Admin')) {
            $items->where('position_id', 2)
            ->orWhere('position_id', 3)
            ->orWhere('position_id', 4);
        }

        $items = $items->get();

        $study_programs = StudyProgram::whereNotIn('name', ['Tim Laboran'])->get();
        return view('pages.lecturer.index', compact('items', 'study_programs'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nis' => ['required', 'max:21', Rule::unique('lecturers', 'nis')->ignore($request->id, 'id')],
                'name' => 'required',
                'email' => ['required', Rule::unique('users', 'email')->ignore($request->user_id, 'id')],
                'gender' => 'required',
                'address' => 'required',
                'phone' => 'required|max:13',
                'study_program_id' => 'required',
                'position' => 'required',
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
                        'password' => Hash::make($request->nis),
                    ]
                );

                if ($request->id == null) {
                    if ($request->position == 2) {
                        $user->assignRole(Role::find([2]));
                    }
                    if ($request->position == 3) {
                        $user->assignRole(Role::find([3]));
                    }
                    if ($request->position == 4) {
                        $user->assignRole(Role::find([4]));
                    }
                }

                if ($request->id != null) {
                    if ($request->position != $user->lecturer->position_id) {
                        $user->roles()->detach();
                        if ($request->position == 2) {
                            $user->assignRole(Role::find([2]));
                        }
                        if ($request->position == 3) {
                            $user->assignRole(Role::find([3]));
                        }
                        if ($request->position == 4) {
                            $user->assignRole(Role::find([4]));
                        }
                    }
                }

                $user->lecturer()->updateOrCreate(
                    [
                        'id' => $request->id
                    ],
                    [
                        'nis' => $request->nis,
                        'name' => $request->name,
                        'email' => $request->email,
                        'gender' => $request->gender,
                        'address' => $request->address,
                        'phone' => $request->phone,
                        'position_id' => $request->position,
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

                return response()->json(['status' => 1, 'message' => 'Data Berhasil Disimpan.']);
            } catch (\Exception $e) {
                DB::rollBack();

                return response()->json(['status' => 0, 'error' => $e->getMessage()]);
            }
        }
    }

    public function show($id)
    {
        $item = Lecturer::with('studyProgram')->find($id);
        $item->position = $item->position();
        return response()->json($item);
    }

    public function edit($id)
    {
        $item = Lecturer::with('studyProgram', 'user')->find($id);
        return response()->json($item);
    }

    public function destroy($id)
    {
        $item = Lecturer::find($id);
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
