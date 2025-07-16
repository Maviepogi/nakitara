<?php
namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'google_id', 'avatar', 'is_admin',
        'two_factor_secret', 'two_factor_enabled', 'failed_attempts', 'locked_until'
    ];

    protected $hidden = [
        'password', 'remember_token', 'two_factor_secret',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'locked_until' => 'datetime',
        'two_factor_enabled' => 'boolean',
        'is_admin' => 'boolean',
    ];

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function logs()
    {
        return $this->hasMany(UserLog::class);
    }

    public function isLocked()
    {
        return $this->locked_until && now()->lessThan($this->locked_until);
    }
}