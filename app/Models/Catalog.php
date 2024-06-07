<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Catalog extends Model
{
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id', 'name', 'path', 'parent_id',
    ];

    public function subCatalogs(): HasMany
    {
        return $this->hasMany(Catalog::class, 'parent_id');
    }

    public function parentCatalog(): BelongsTo
    {
        return $this->belongsTo(Catalog::class, 'parent_id');
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'catalog_roles', 'catalog_id', 'role_id');
    }

    public static function generatePathForCatalog($catalog)
    {
        $path = [];
        while ($catalog) {
            array_unshift($path, $catalog->name);
            $catalog = $catalog->parentCatalog;
        }
        return 'storage/' . implode('/', $path);
    }
}
