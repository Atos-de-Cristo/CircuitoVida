<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_send',
        'user_for',
        'event_id',
        'lesson_id',
        'message',
        'read',
        'date_send',
        'date_read'
    ];

    public function userSend(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_send');
    }

    public function userFor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_for');
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }
}
