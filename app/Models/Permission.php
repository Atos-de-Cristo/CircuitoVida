<?php

namespace App\Models;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Permission extends Model implements Auditable
{
    use AuditableTrait;
    use HasFactory;

    public $timestamps = false;

    protected $table = 'permissions';

    protected $fillable = [ 'permission' ];

    public function users(): BelongsToMany {
        return $this->belongsToMany(User::class);
    }

    public static function getAllFromCache(): Collection {
        $permissions = Cache::rememberForever('permissions', function () {
            return DB::table('permissions')->get();
        });
        return $permissions;
    }

    public static function getPermission(string $permission) {
        $p = self::getAllFromCache()->where('permission', $permission)->first();
        if (!$p) {
            $p = Permission::query()->create(['permission' => $permission]);
        }
        return $p->id;
    }

    public static function existsOnCache(string $permission): bool {
        return self::getAllFromCache()->where('permission', $permission)->isNotEmpty();
    }
}
