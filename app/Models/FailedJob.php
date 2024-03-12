<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class FailedJob extends Model
{
    // Określenie, że klucz główny nie jest liczbą autoinkrementowaną
    public $incrementing = false;

    // Określenie, że klucz główny to string (UUID)
    protected $keyType = 'string';

    // Ustawienie, że model nie powinien być strzeżony (mass-assignable bez ograniczeń)
    protected $guarded = [];

    // Ustawienie nazwy tabeli, jeśli jest inna niż domyślna konwencja Laravela
    protected $table = 'failed_jobs';

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
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

    /**
     * Relacja do użytkownika, który jest powiązany z nieudanym zadaniem.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Dodatkowe metody lub logika specyficzna dla nieudanych zadań mogą zostać tutaj dodane
}
