<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActiveVillage extends Model
{
    use HasFactory, Sluggable;

    protected $fillable = [
        'village_id',
        'name',
        'slug',
        'email',
        'phone',
        'rw',
        'rt',
        'head_village',
    ];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function village()
    {
        return $this->belongsTo(Village::class, 'village_id');
    }

    public function user()
    {
        return $this->belongsToMany(User::class)->using(ActiveVillageUser::class);
    }
}
