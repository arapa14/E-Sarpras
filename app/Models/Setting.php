<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'locations';

    protected $fillable = [
        'key',
        'value',
    ];
}
