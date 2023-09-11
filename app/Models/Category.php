<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Category extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;

    protected $fillable = [ 'name' ];

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

}
