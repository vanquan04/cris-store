<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ai_knowledge extends Model
{
        protected $table = 'ai_knowledge';
        protected $fillable = [
        'category', 'id', 'title', 'content', 'creator'
    ];
}
