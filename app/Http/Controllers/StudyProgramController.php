<?php

namespace App\Http\Controllers;

use App\Models\StudyProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class StudyProgramController extends Controller
{
    public function index()
    {
        $items = StudyProgram::get();
        return view('pages.study-program.index', compact('items'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'code' => ['required ', Rule::unique('study_programs', 'code')->ignore($request->id, 'id')],
                'name' => 'required'
            ],
        );

        if ($validator->fails()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            try {
                StudyProgram::updateOrCreate(
                    [
                        'id' => $request->id
                    ],
                    [
                        'code' => $request->code,
                        'name' => $request->name
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
        $data = StudyProgram::find($id);
        return response()->json($data);
    }

    public function edit($id)
    {
        $data = StudyProgram::find($id);
        return response()->json($data);
    }

    public function destroy($id)
    {
        $data = StudyProgram::find($id);
        $data->delete();
        return response()->json(['success' => 'Data Berhasil Dihapus.']);
    }
}
