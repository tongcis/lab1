<?php

namespace Database\Seeders;

use App\Models\StudyProgram;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudyProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            [
                'code' => '1',
                'name' => 'Tim Laboran'
            ],
            [
                'code' => '55202',
                'name' => 'Program Sarjana Informatika'
            ],
            [
                'code' => '26201',
                'name' => 'Program Sarjana Teknik Industri'
            ],
            [
                'code' => '20401',
                'name' => 'Program Teknologi Rekayasa Elektro-Medis'
            ],
            [
                'code' => '23201',
                'name' => 'Program Sarjana Arsitektur'
            ],
            [
                'code' => '11410',
                'name' => 'Program Sarjana Biomedis'
            ],
            [
                'code' => '48201',
                'name' => 'Program Sarjana Farmasi'
            ],
            [
                'code' => '13211',
                'name' => 'Program Sarjana Gizi'
            ],
            [
                'code' => '89201',
                'name' => 'Program Sarjana Ilmu Keolahragaan'
            ],
            [
                'code' => '0',
                'name' => 'Program Sarjana Lain-Nya'
            ],
        ];

        StudyProgram::insert($datas);
    }
}
