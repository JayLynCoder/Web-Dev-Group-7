<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Model
{
    public $timestamps = false;

    protected $fillable = ['email', 'username', 'full_name', 'password_hash', 'is_admin'];

    protected $hidden = ['password_hash'];

    protected function casts(): array
    {
        return ['is_admin' => 'boolean'];
    }

    /** The employee record linked to this login (null for admins / unlinked accounts). */
    public function employee(): HasOne
    {
        return $this->hasOne(Employee::class);
    }

    /** The user that is logged in right now (this app stores user_id in the session). */
    public static function current(): ?self
    {
        return session()->has('user_id') ? static::find(session('user_id')) : null;
    }
}
