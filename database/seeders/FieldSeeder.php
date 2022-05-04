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
            'name' => 'Bid.Perpustakaan',
            'slug' => 'bid_perpustakaan'
        ]);

        Field::create([
            'name' => 'Bid.Perlindungan dan Penyelamatan Arsip',
            'slug' => 'bid_perlindungan_dan_penyelamatan_arsip'
        ]);

        Field::create([
            'name' => 'Bid.Pengelolaan Arsip',
            'slug' => 'bid_pengelolaan_arsip'
        ]);
    }
}
