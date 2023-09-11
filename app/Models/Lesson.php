<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Lesson extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;

    protected $fillable = [
        'user_id',
        'event_id',
        'module_id',
        'title',
        'description',
        'video',
        'start_date',
        'end_date'
    ];

    public function event(): BelongsTo{
        return $this->belongsTo(Event::class);
    }

    public function module(): BelongsTo{
        return $this->belongsTo(Module::class);
    }

    public function activities(): HasMany{
        return $this->hasMany(Activity::class);
    }

    public function attachments(): HasMany{
        return $this->hasMany(Attachment::class);
    }

    public function frequency(): HasMany{
        return $this->hasMany(Frequency::class);
    }
}
