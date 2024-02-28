<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class logintime extends Model
{
    use HasFactory;
    protected $fillable = [
        'ipaddress',
        'start_time',
        'end_time',
    ];
}
