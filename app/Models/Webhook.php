<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Webhook extends Model
{
    protected $table = 'webhook';

    protected $fillable = [
        'aplikasi',
        'url',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean'
    ];
}
