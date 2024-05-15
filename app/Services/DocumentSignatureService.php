<?php

namespace App\Services;

use App\Models\EncryptionKey;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class DocumentSignatureService
{
    /**
     * Generuje klucz jednorazowy dla podanej wersji dokumentu i zapisuje go lokalnie na komputerze użytkownika.
     *
     * @param string $documentVersionId Identyfikator wersji dokumentu.
     * @return EncryptionKey Wygenerowany i zapisany klucz jednorazowy.
     */
    public function generateOneTimeKey(string $documentVersionId): EncryptionKey
    {
        $oneTimeKey = Str::random(64); // Generowanie silnego klucza jednorazowego.

        // Zapisywanie klucza lokalnie na komputerze użytkownika
        $pathToLocalUserSystem = '/ścieżka/do/systemu/użytkownika';  // Należy dostosować ścieżkę
        file_put_contents("$pathToLocalUserSystem/{$documentVersionId}.key", $oneTimeKey);

        // Tworzenie i zapisywanie nowego klucza jednorazowego w bazie danych.
        $encryptionKey = new EncryptionKey([
            'document_version_id' => $documentVersionId,
            'encryption_key' => $oneTimeKey,
        ]);

        $encryptionKey->save(); // Zapisywanie klucza do bazy danych.

        return $encryptionKey;
    }

    /**
     * Archiwizuje użyty klucz jednorazowy.
     *
     * @param EncryptionKey $encryptionKey Klucz do zarchiwizowania.
     * @return bool Status archiwizacji.
     */
    public function archiveKey(EncryptionKey $encryptionKey): bool
    {
        // Przenieś klucz do archiwum (np. inna tabela, magazyn plików itp.).
        Storage::disk('local')->put("archive/keys/$encryptionKey->id.key", $encryptionKey->encryption_key);

        // Oznacz klucz w bazie danych jako zarchiwizowany.
        $encryptionKey->archived_at = now();
        $encryptionKey->save();

        return true;
    }

    /**
     * Szyfruje dane używając klucza jednorazowego.
     *
     * @param string $data Dane do zaszyfrowania.
     * @param EncryptionKey $encryptionKey Klucz szyfrowania.
     * @return string Zaszyfrowane dane.
     */
    public function encryptData(string $data, EncryptionKey $encryptionKey): string
    {
        return openssl_encrypt($data, 'AES-256-CBC', $encryptionKey->encryption_key);
    }

    /**
     * Deszyfruje dane używając klucza jednorazowego.
     *
     * @param string $encryptedData Zaszyfrowane dane.
     * @param EncryptionKey $encryptionKey Klucz szyfrowania.
     * @return string Odszyfrowane dane.
     */
    public function decryptData(string $encryptedData, EncryptionKey $encryptionKey): string
    {
        return openssl_decrypt($encryptedData, 'AES-256-CBC', $encryptionKey->encryption_key);
    }
}
