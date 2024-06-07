<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class EncryptionKey extends Model
{
    public $incrementing = false;
    public $timestamps = false; // Jeśli nie masz kolumn created_at i updated_at

    protected $primaryKey = 'document_version_id'; // Klucz główny to document_version_id

    protected $fillable = [
        'document_version_id', 'encryption_key', 'used_at', 'is_archived'
    ];

    /**
     * Get the document version that owns the encryption key.
     */
    public function documentVersion(): BelongsTo
    {
        return $this->belongsTo(DocumentVersion::class, 'document_version_id');
    }
}
