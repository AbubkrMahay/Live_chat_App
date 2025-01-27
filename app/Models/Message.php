<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $fillable = ['sender_id', 'receiver_id', 'content','group_id'];
    // The user who sent the message
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    // The user who received the message
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
