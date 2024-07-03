<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            [
                'name' => 'Lab Multimedia'
            ],
            [
                'name' => 'Lab Desain'
            ],
            [
                'name' => 'Lab Rekayasa'
            ],
            [
                'name' => 'Lab IoT'
            ],
            [
                'name' => 'Lab Studio 1'
            ],
            [
                'name' => 'Lab Bigdata'
            ],
            [
                'name' => 'Lab Fisika'
            ],
            [
                'name' => 'Lab Studio 2'
            ],
            [
                'name' => 'Lab Industri'
            ],
        ];

        Room::insert($datas);
    }
}
