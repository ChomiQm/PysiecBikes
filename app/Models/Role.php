<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    use HasFactory;
    use HasUuids;

    protected $keyType = 'string';
    protected $primaryKey = 'uuid';
    public $incrementing = 'false';

    public function catalogs(): BelongsToMany
    {
        return $this->belongsToMany(Catalog::class, 'catalog_roles');
    }
}
