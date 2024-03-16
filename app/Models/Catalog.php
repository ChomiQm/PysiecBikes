<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Catalog extends Model
{
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id', 'name', 'parent_id',
    ];

    /**
     * Get the sub-catalogs for the catalog.
     */
    public function subCatalogs(): HasMany
    {
        return $this->hasMany(Catalog::class, 'parent_id');
    }

    /**
     * Get the parent catalog of the catalog.
     */
    public function parentCatalog(): BelongsTo
    {
        return $this->belongsTo(Catalog::class, 'parent_id');
    }

    /**
     * The roles that belong to the catalog.
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'catalog_roles');
    }
}
