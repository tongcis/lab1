<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function reset($id)
    {
        $data = User::find($id);
        if (isset($data->student)) {
            $data->update([
                'password' => bcrypt($data->student->nim),
            ]);
        }
        if (isset($data->lecturer)) {
            $data->update([
                'password' => bcrypt($data->lecturer->nis),
            ]);
        }
        return response()->json(['success' => 'Password Berhasil Direset.']);
    }
}
