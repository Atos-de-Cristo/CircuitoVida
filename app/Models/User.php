<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Permission;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Cache;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function permissions(): BelongsToMany {
        return $this->belongsToMany(Permission::class);
    }

    public function givePermissionTo(string $permission): void {
        $p = Permission::getPermission($permission);
        $this->permissions()->attach($p);
        Cache::forget('permissions::of::user::'.$this->id);
    }

    public function hasPermissionTo(string $permission): bool {
        $permissionOfUser = Cache::rememberForever('permissions::of::user::'.$this->id, function() {
            return $this->permissions()->get();
        });

        return $permissionOfUser->where('permission', $permission)->isNotEmpty();
    }
}
