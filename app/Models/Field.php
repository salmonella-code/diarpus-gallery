<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function user()
    {
        return $this->hasOne(User::class, 'field_id');
    }

    public function galleries()
    {
        return $this->hasMany(Gallery::class, 'field_id');
    }
}
