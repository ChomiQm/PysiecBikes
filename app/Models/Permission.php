<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    use HasFactory, HasUuids;

    // Definiuj typ klucza głównego jako 'string'
    protected $keyType = 'string';
    // Określ uuid jako klucz główny
    protected $primaryKey = 'uuid';
    // Wyłącz auto-incrementing dla uuid
    public $incrementing = false;

    // Określ pola, które mogą być wypełnione
    protected $fillable = [
        'uuid',
        'name',
        'guard_name',
    ];

    // Przedefiniuj boot, aby ustawić uuid przy tworzeniu
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }
}
