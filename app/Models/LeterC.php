<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeterC extends Model
{
    use HasFactory;

    protected $fillable = [
        'village_id',
        'register_number',
        'name',
        'address',
        'scan',
    ];

    public function village()
    {
        return $this->belongsTo(ActiveVillage::class, 'village_id');
    }
}
