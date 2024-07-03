<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class Lecturer extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function studyProgram()
    {
        return $this->belongsTo(StudyProgram::class, 'study_program_id');
    }

    public function position()
    {
        switch ($this->position_id) {
            case 2:
                return "Tim Laboratorium";
                break;
            case 3:
                return "Pimpinan";
                break;
            case 4:
                return "Dosen";
                break;
            default:
                return "Jabatan tidak ditemukan";
        }
    }
}
