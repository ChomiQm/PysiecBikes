<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EncryptionKey extends Model
{
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'document_version_id', 'encryption_key', 'role_id',
    ];

    /**
     * The document version that owns the encryption key.
     */
    public function documentVersion(): BelongsTo
    {
        return $this->belongsTo(DocumentVersion::class, 'document_version_id');
    }

    /**
     * The role that the encryption key belongs to.
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}
