<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class FieldUser extends Pivot
{
    use HasFactory;

    protected $table = 'field_user';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'field_id'
    ];
}
