<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Village extends Model
{
    use HasFactory, Sluggable;

    protected $fillable = [
        'province',
        'regency',
        'district',
        'village',
        'email',
        'phone',
        'rw',
        'rt',
        'head_village',
        'slug',
    ];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'village'
            ]
        ];
    }
}
