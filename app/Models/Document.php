<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Document extends Model
{
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id', 'name', 'current_version_id',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted(): void
    {
        static::creating(function ($document) {
            if (empty($document->id)) {
                $document->id = (string) Str::uuid();
            }
        });
    }

    /**
     * Get the versions for the document.
     */
    public function versions(): HasMany
    {
        return $this->hasMany(DocumentVersion::class, 'document_id');
    }

    /**
     * Get the current version of the document.
     */
    public function currentVersion(): BelongsTo
    {
        return $this->belongsTo(DocumentVersion::class, 'current_version_id');
    }

    /**
     * The roles that have access to the document.
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'document_access', 'document_id', 'role_id');
    }

    /**
     * The access records related to the document.
     */
    public function access(): HasMany
    {
        return $this->hasMany(DocumentAccess::class, 'document_id');
    }
}
