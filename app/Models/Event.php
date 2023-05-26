<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
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
}
