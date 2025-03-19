<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $table = 'complaints';

    protected $fillable = [
        'user_id',
        'description',
        'location',
        'suggestion',
        'before_image',
        'status',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function response() {
        return $this->hasMany(Response::class);
    }
}
