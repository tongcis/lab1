<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Super Admin'
            ],
            [
                'name' => 'Laboratory Team'
            ],
            [
                'name' => 'Leader'
            ],
            [
                'name' => 'Lecturer'
            ],
            [
                'name' => 'Student'
            ]
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }

        $admin = User::create([
            'name' => 'Super Admin',
            'email' => 'super@mail.com',
            'password' => Hash::make('superadmin#'),
        ]);

        $admin->assignRole([1]);

        $this->call([
            StudyProgramSeeder::class,
            RoomSeeder::class,
            TypeOfRoomSeeder::class,
        ]);
    }
}
