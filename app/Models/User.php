<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public $timestamps = false;

    protected $fillable = ['email', 'username', 'full_name', 'password_hash', 'is_admin'];
}