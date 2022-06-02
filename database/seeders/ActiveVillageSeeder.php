<?php

namespace Database\Seeders;

use App\Models\ActiveVillage;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class ActiveVillageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $village = ActiveVillage::create([
            'village_id' => '3202171002',
            'name' => 'DESA JAMBENENGGANG',
            'slug' => SlugService::createSlug(ActiveVillage::class, 'slug', 'DESA JAMBENENGGANG'),
        ]);

        if (!File::isDirectory('village/'.$village->slug)) {
            File::makeDirectory('village/'.$village->slug, 0777, true, true);
            File::makeDirectory('village/'.$village->slug.'/leter-c', 0777, true, true);
            File::makeDirectory('village/'.$village->slug.'/photo', 0777, true, true);
            File::makeDirectory('village/'.$village->slug.'/video', 0777, true, true);
        }
    }
}
