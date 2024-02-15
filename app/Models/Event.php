<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, BelongsToMany, HasMany};
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Event extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;

    protected $fillable = [
        'type',
        'category_id',
        'name',
        'image',
        'start_date',
        'end_date',
        'local',
        'description',
        'tickets_limit',
        'value',
        'status'
    ];

    public function inscriptions(): HasMany {
        return $this->hasMany(Inscription::class);
    }

    public function modules(): HasMany{
        return $this->hasMany(Module::class);
    }

    public function lessons(): HasMany{
        return $this->hasMany(Lesson::class);
    }

    public function attachments(): HasMany{
        return $this->hasMany(Attachment::class);
    }

    public function monitors(): BelongsToMany {
        return $this->belongsToMany(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
