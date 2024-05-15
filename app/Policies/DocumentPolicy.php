<?php

namespace App\Policies;

use App\Models\Document;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DocumentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the document.
     */
    public function view(User $user, Document $document)
    {
        // Logika sprawdzania, czy użytkownik może przeglądać dokument
        return true; // Zmień zgodnie z wymaganiami
    }

    /**
     * Determine whether the user can create documents.
     */
    public function create(User $user)
    {
        // Logika sprawdzania, czy użytkownik może tworzyć dokumenty
        return true; // Zmień zgodnie z wymaganiami
    }

    /**
     * Determine whether the user can update the document.
     */
    public function update(User $user, Document $document)
    {
        // Logika sprawdzania, czy użytkownik może edytować dokument
        return true; // Zmień zgodnie z wymaganiami
    }

    /**
     * Determine whether the user can delete the document.
     */
    public function delete(User $user, Document $document)
    {
        // Logika sprawdzania, czy użytkownik może usuwać dokument
        return true; // Zmień zgodnie z wymaganiami
    }
}
