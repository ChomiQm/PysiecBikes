<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class DocumentVersion extends Model
{
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id', 'document_id', 'version_number', 'file_path', 'checksum', 'created_by'
    ];

    /**
     * Get the document that owns the version.
     */
    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class, 'document_id');
    }

    /**
     * The encryption key for the document version.
     */
    public function encryptionKey(): HasOne
    {
        return $this->hasOne(EncryptionKey::class, 'document_version_id');
    }

    /**
     * Get the user who created the version.
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    protected static function booted(): void
    {
        static::creating(function ($version) {
            if (empty($version->id)) {
                $version->id = (string) Str::uuid();
            }
        });
    }
}
