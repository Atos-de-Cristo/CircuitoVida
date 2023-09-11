<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Module extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;

    protected $fillable = [ 'name', 'event_id' ,];

    public function event(): BelongsTo{
        return $this->belongsTo(Event::class);
    }

    public function lessons(): HasMany{
        return $this->hasMany(Lesson::class);
    }

}
