<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
