<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ActiveVillageUser extends Pivot
{
    use HasFactory;

    protected $table = 'village_user';
    public $timestamps = false;


    protected $fillable = [
        'user_id',
        'active_village_id',
    ];
}
