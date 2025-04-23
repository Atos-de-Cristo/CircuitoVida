<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Frequency extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;

    protected $fillable = [
        'event_id',
        'user_id',
        'lesson_id',
        'inscription_id',
        'justification',
        'is_justified',
        'is_present'
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function inscription(): BelongsTo
    {
        return $this->belongsTo(Inscription::class);
    }
}
