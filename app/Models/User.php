<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    // User's connections
    public function connections()
    {
        return $this->belongsToMany(User::class, 'connections', 'user_id', 'connected_user_id')
                    ->withPivot('status')
                    ->wherePivot('status', 'accepted');
    }

    // Connection requests sent by the user
    public function sentRequests()
    {
        return $this->hasMany(Connection::class, 'user_id');
    }

    // Connection requests received by the user
    public function receivedRequests()
    {
        return $this->hasMany(Connection::class, 'connected_user_id');
    }

    // Messages sent by the user
    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    // Messages received by the user
    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }
    public function groups()
{
    return $this->belongsToMany(Group::class);
}
}
