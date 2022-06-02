<?php

namespace Database\Seeders;

use App\Models\Field;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class FieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bidPerpus = Field::create([
            'name' => 'Bid.Perpustakaan',
            'slug' => SlugService::createSlug(Field::class, 'slug', 'Bid.Perpustakaan')
        ]);
        if (!File::isDirectory('field/'.$bidPerpus->slug)) {
            File::makeDirectory('field/'.$bidPerpus->slug, 0777, true, true);
            File::makeDirectory('field/'.$bidPerpus->slug.'/photo', 0777, true, true);
            File::makeDirectory('field/'.$bidPerpus->slug.'/video', 0777, true, true);
        }

        $bidPerlindungan = Field::create([
            'name' => 'Bid.Perlindungan dan Penyelamatan Arsip',
            'slug' => SlugService::createSlug(Field::class, 'slug', 'Bid.Perlindungan dan Penyelamatan Arsip')
        ]);
        if (!File::isDirectory('field/'.$bidPerlindungan->slug)) {
            File::makeDirectory('field/'.$bidPerlindungan->slug, 0777, true, true);
            File::makeDirectory('field/'.$bidPerlindungan->slug.'/photo', 0777, true, true);
            File::makeDirectory('field/'.$bidPerlindungan->slug.'/video', 0777, true, true);
        }

        $bidPengelolaan = Field::create([
            'name' => 'Bid.Pengelolaan Arsip',
            'slug' => SlugService::createSlug(Field::class, 'slug', 'Bid.Pengelolaan Arsip')
        ]);
        if (!File::isDirectory('field/'.$bidPengelolaan->slug)) {
            File::makeDirectory('field/'.$bidPengelolaan->slug, 0777, true, true);
            File::makeDirectory('field/'.$bidPengelolaan->slug.'/photo', 0777, true, true);
            File::makeDirectory('field/'.$bidPengelolaan->slug.'/video', 0777, true, true);
        }
    }
}
