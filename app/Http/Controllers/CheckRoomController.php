<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomApplication;
use Illuminate\Support\Facades\Log;

class CheckRoomController extends Controller
{
    public function check()
    {
        // Ambil semua aplikasi kamar yang statusnya adalah 2 (misalnya dalam proses)
        $items = RoomApplication::where('status', 2)->get();

        // Ambil semua kamar
        $rooms = Room::get();

        // Loop melalui setiap kamar
        foreach ($rooms as $room) {
            // Filter aplikasi kamar yang terkait dengan kamar saat ini
            $roomApplications = $items->where('room_id', $room->id);

            // Loop melalui aplikasi kamar terkait dengan kamar saat ini
            foreach ($roomApplications as $application) {
                // Periksa apakah waktu berakhirnya telah lewat
                if ($application->end_time < now()->format('H:i:s')) {
                    Log::info('Hai' . $application);
                    // Perbarui status aplikasi kamar menjadi 4 (misalnya kadaluwarsa)
                    $application->update(['status' => 4]);

                    // Perbarui status kamar menjadi 0 (misalnya tersedia)
                    $room->update(['status' => 0]);
                }
            }
        }
    }

    // Fungsi untuk memeriksa apakah waktu berakhir telah lewat
    private function isEndTimePassed($endTime)
    {
        return $endTime < now();
    }
}
