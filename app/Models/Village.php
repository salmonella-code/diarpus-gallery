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

    public function galleries()
    {
        return $this->hasMany(Gallery::class, 'village_id');
    }

    public function user()
    {
        return $this->belongsToMany(User::class, 'village_user', 'village_id', 'user_id');
    }
}
