<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    use HasFactory, Sluggable;

    protected $fillable = [
        'name',
        'slug'
    ];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function user()
    {
        return $this->hasOne(User::class, 'field_id');
    }

    public function galleries()
    {
        return $this->hasMany(Gallery::class, 'field_id');
    }

    public function photos()
    {
        return $this->galleries()->where('category', 'photo');
    }

    public function videos()
    {
        return $this->galleries()->where('category', 'video');
    }
}
