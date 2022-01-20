<?php

namespace Database\Seeders;

use App\Models\Field;
use Illuminate\Database\Seeder;

class FieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Field::create([
            'name' => 'Bid.Perpustakaan'
        ]);

        Field::create([
            'name' => 'Bid.Perlindungan dan Penyelamatan Arsip'
        ]);

        Field::create([
            'name' => 'Bid.Pengelolaan Arsip'
        ]);
    }
}
