<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'event_id',
        'module_id',
        'title',
        'description',
        'video',
        'slide',
        'date'
    ];

    public function event(): BelongsTo{
        return $this->belongsTo(Event::class);
    }

    public function module(): BelongsTo{
        return $this->belongsTo(Module::class);
    }
}
