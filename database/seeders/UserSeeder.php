<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'field_id' => null,
            'nip' => null,
            'group' => null,
            'position' => 'kepala dinas',
            'name' => 'eman',
            'contact' => '085889452316',
            'email' => 'admin@test.com',
            'password' => Hash::make(12345678),
            'role' => 'admin',
            'avatar' => '1642563658.jpg'
        ]);

        User::create([
            'field_id' => 1,
            'nip' => null,
            'group' => null,
            'position' => 'kepala bidang',
            'name' => 'iman surahman',
            'contact' => '085789452316',
            'email' => 'user@test.com',
            'password' => Hash::make(12345678),
            'role' => 'user',
            'avatar' => 'avatar.jpg'
        ]);
    }
}
