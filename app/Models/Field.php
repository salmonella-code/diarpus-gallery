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
        return $this->belongsToMany(User::class)->using(FieldUser::class);
    }

    public function photos()
    {
        return $this->hasMany(Gallery::class, 'field_id')->where('category', 'photo');
    }

    public function videos()
    {
        return$this->hasMany(Gallery::class, 'field_id')->where('category', 'video');
    }
}
