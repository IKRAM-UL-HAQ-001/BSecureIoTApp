<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IoTDevice extends Model
{
    protected $table = 'iot_devices';
    use HasFactory;
    protected $fillable = [
        "name","iot_address","mac_address"
    ];
}
