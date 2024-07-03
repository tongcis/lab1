<?php

namespace Database\Seeders;

use App\Models\TypeOfRoom;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeOfRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            [
                'name' => 'Pembelajaran',
                'is_learning' => 1
            ],
            [
                'name' => 'Penelitian',
                'is_learning' => 0
            ],
            [
                'name' => 'Pengabdian',
                'is_learning' => 0
            ],
            [
                'name' => 'Pengembangan',
                'is_learning' => 1
            ],
            [
                'name' => 'Rapat',
                'is_learning' => 0
            ],
        ];

        TypeOfRoom::insert($datas);
    }
}
