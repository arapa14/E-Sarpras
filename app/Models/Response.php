<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    protected $table = 'responses';

    protected $fillable = [
        'complaint_id',
        'feedback',
        'after_image',
        'response_time',
    ];

    public function complaint() {
        return $this->belongsTo(Complaint::class);
    }
}
