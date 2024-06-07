<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatalogRole extends Model
{
    public $incrementing = false;
    protected $fillable = [
        'catalog_id', 'role_id'
    ];

    public function catalog()
    {
        return $this->belongsTo(Catalog::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}
