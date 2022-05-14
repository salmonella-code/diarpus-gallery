<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory, Sluggable;

    protected $fillable = [
        'user_id', 
        'field_id', 
        'name',
        'slug',
        'category', 
        'description', 
        'activity'
    ];

    protected $dates = [
        'activity'
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
        return $this->belongsTo(User::class, 'user_id');
    }

    public function field()
    {
        return $this->belongsTo(Field::class, 'field_id');
    }

    public function files()
    {
        return $this->hasMany(File::class, 'gallery_id');
    }
}
