<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
        protected $table = 'chat_messages';
    protected $fillable = ['session_id', 'sender', 'content'];

    // Mỗi tin nhắn thuộc về 1 phiên
    public function session()
    {
        return $this->belongsTo(ChatSession::class, 'session_id');
    }
}
