<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DocumentVersion extends Model
{
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id', 'document_id', 'version_number', 'file_path', 'checksum', 'created_by',
    ];

    /**
     * Get the document that owns the version.
     */
    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class, 'document_id');
    }

    /**
     * The encryption keys for the document version.
     */
    public function encryptionKeys(): HasMany
    {
        return $this->hasMany(EncryptionKey::class, 'document_version_id');
    }
}
