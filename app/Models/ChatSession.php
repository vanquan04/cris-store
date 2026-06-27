<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatSession extends Model
{
    protected $table = 'chat_sessions';
    protected $fillable = ['user_name', 'ip_address', 'started_at', 'ended_at'];

    // Một phiên có nhiều tin nhắn
    public function messages()
    {
        return $this->hasMany(ChatMessage::class, 'session_id');
    }
}
