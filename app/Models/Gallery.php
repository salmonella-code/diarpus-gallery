<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'field_id', 
        'name',
        'slug',
        'category', 
        'description', 
    ];

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
