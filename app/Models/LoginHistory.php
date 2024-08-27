<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoginHistory extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'login_histories';
    protected $fillable = [
        'user_id',
        "username",
        "login_at",
        "ip_address",
    ];
}
