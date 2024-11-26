<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Connection extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'connected_user_id', 'status'];
    public function sender()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // The user who received the connection request
    public function receiver()
    {
        return $this->belongsTo(User::class, 'connected_user_id');
    }
}
