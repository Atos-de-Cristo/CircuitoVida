<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [ 'activity_id', 'type', 'title', 'options' ];

    public function activity(): BelongsTo
    {
        return $this->belongsTo(Activity::class);
    }

    public function Response(): HasMany
    {
        return $this->hasMany(Response::class);
    }
}
