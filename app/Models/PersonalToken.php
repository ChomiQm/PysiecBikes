<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PersonalToken extends Model
{
    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'user_id', 'name', 'token', 'abilities', 'last_used_at', 'expires_at', 'token_type'
    ];

    protected static function boot(): void
    {
        parent::boot();

        // Auto-generowanie UUID przed stworzeniem nowego modelu
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }
}
