<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\{BelongsToMany, HasMany, HasOne};
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\{HasProfilePhoto, HasTeams};
use Laravel\Sanctum\HasApiTokens;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class User extends Authenticatable implements Auditable
{
    use AuditableTrait;
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function permissions(): BelongsToMany {
        return $this->belongsToMany(Permission::class, 'permission_user', 'user_id', 'permission_id');
    }

    public function activities(): BelongsToMany {
        return $this->belongsToMany(Activity::class);
    }

    public function frequencies(): BelongsToMany {
        return $this->belongsToMany(Frequency::class);
    }

    public function events(): BelongsToMany {
        return $this->belongsToMany(Event::class);
    }

    public function inscriptions(): HasMany {
        return $this->hasMany(Inscription::class);
    }

    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }

    public function responses(): HasMany {
        return $this->hasMany(Response::class);
    }

    public function monitors(): BelongsToMany {
        return $this->belongsToMany(Event::class);
    }

    public function givePermissionTo(string $permission): void {
        $p = Permission::getPermission($permission);
        $this->permissions()->attach($p);
        Cache::forget('permissions::of::user::'.$this->id);
    }

    public function hasPermissionTo(string $permission): bool {
        $permissionOfUser = Cache::rememberForever('permissions::of::user::'.$this->id, function() {
            return explode(',', $this->permissions()->implode('permission', ','));
        });

        return in_array($permission, $permissionOfUser);
    }
}
