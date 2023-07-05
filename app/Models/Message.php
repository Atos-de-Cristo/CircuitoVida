<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user_send(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_send');
    }

    public function user_for(): BelongsTo
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
