<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use File as FileF;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'gallery_id',
        'name',
        'folder'
    ];

    public function gallery()
    {
        return $this->belongsTo(Gallery::class, 'gallery_id');
    }
}
