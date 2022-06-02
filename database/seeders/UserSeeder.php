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
        $admin = User::create([
            'nip' => null,
            'group' => null,
            'position' => 'kepala dinas',
            'name' => 'eman',
            'contact' => '085889452316',
            'email' => 'admin@test.com',
            'password' => Hash::make(12345678),
            'avatar' => 'avatar.jpg'
        ]);
        $admin->assignRole('admin');

        $user = User::create([
            'nip' => null,
            'group' => null,
            'position' => 'kepala bidang',
            'name' => 'iman surahman',
            'contact' => '085789452316',
            'email' => 'user@test.com',
            'password' => Hash::make(12345678),
            'avatar' => 'avatar.jpg'
        ]);
        $user->assignRole('user');
        $user->field()->attach(1);

        $village = User::create([
            'nip' => null,
            'group' => null,
            'position' => 'kepala desa',
            'name' => 'ajol desa',
            'contact' => '085789452309',
            'email' => 'village@test.com',
            'password' => Hash::make(12345678),
            'avatar' => 'avatar.jpg'
        ]);
        $village->assignRole('village');
        $village->field()->attach(1);
    }
}
