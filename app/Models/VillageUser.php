<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class VillageUser extends Pivot
{
    use HasFactory;

    protected $table = 'village_user';

    protected $fillable = [
        'user_id',
        'village_id',
    ];

    public function village()
    {
        return $this->belongsTo(Village::class);
    }
}
