<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    protected $fillable = ['user_id', 'room_id', 'content'];

    public function user(): BelongsTo
    {
        return $table = $this->belongsTo(User::class);
    }
}

