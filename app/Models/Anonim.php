<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anonim extends Model
{
    protected $table = 'anonims';

    protected $fillable = [
        'ticket',
        'description',
        'location',
        'suggestion',
        'before_image',
        'status',
    ];

    public function responses() {
        return $this->hasMany(Response::class, 'complaint_id');
    }
}
