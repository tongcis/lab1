<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\StudyProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CourseController extends Controller
{
    public function index()
    {
        $items = Course::with('studyProgram')->get();
        $study_programs = StudyProgram::whereNotIn('name', ['Tim Laboran'])->get();
        return view('pages.course.index', compact('items', 'study_programs'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'code' => ['required ', Rule::unique('courses', 'code')->ignore($request->id, 'id')],
                'name' => 'required',
                'study_program_id' => 'required',
            ],
        );

        if ($validator->fails()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            try {
                Course::updateOrCreate(
                    [
                        'id' => $request->id
                    ],
                    [
                        'code' => $request->code,
                        'name' => $request->name,
                        'study_program_id' => $request->study_program_id
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
        $data = Course::with('studyProgram')->find($id);
        return response()->json($data);
    }

    public function edit($id)
    {
        $data = Course::find($id);
        return response()->json($data);
    }

    public function destroy($id)
    {
        $data = Course::find($id);
        $data->delete();
        return response()->json(['success' => 'Data Berhasil Dihapus.']);
    }
}
