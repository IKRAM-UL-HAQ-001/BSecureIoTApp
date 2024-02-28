<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlockedIp extends Model
{
    use HasFactory;
    // protected $table = 'blocked_ips'; // Specify the table name if it's different from the model name
    protected $fillable = ['ipaddress','attempts', 'is_blocked', 'blocked_until']; // Define fillable fields
}
