<?php

namespace App\Policies;

use App\Models\Document;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Role;

class DocumentPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Document $document)
    {
        if ($document->roles->isEmpty()) {
            return true;
        }

        if ($user->roles->intersect($document->roles)->isNotEmpty()) {
            return true;
        }

        foreach ($user->roles as $userRole) {
            foreach ($document->roles as $documentRole) {
                if ($this->isHigherOrEqualRole($userRole, $documentRole)) {
                    return true;
                }
            }
        }

        return false;
    }

    public function create(User $user)
    {
        return $user->roles->isNotEmpty();
    }

    public function update(User $user, Document $document)
    {
        if ($document->roles->isEmpty()) {
            return true;
        }

        // CEO może edytować wszystkie dokumenty
        if ($user->hasRole('CEO')) {
            return true;
        }

        // Sprawdzenie, czy użytkownik jest właścicielem dokumentu
        if ($document->created_by == $user->id) {
            return true;
        }

        // Sprawdzenie, czy rola użytkownika jest wyższa niż jakakolwiek z ról dokumentu
        foreach ($user->roles as $userRole) {
            foreach ($document->roles as $documentRole) {
                if ($this->isHigherRole($userRole, $documentRole)) {
                    return false;
                }
                if ($this->isHigherOrEqualRole($userRole, $documentRole)) {
                    return true;
                }
            }
        }

        return false;
    }

    public function delete(User $user, Document $document)
    {
        if ($document->roles->isEmpty()) {
            return true;
        }

        // CEO może usuwać wszystkie dokumenty
        if ($user->hasRole('CEO')) {
            return true;
        }

        // Sprawdzenie, czy użytkownik jest właścicielem dokumentu
        if ($document->created_by == $user->id) {
            return true;
        }

        // Sprawdzenie, czy rola użytkownika jest wyższa niż jakakolwiek z ról dokumentu
        foreach ($user->roles as $userRole) {
            foreach ($document->roles as $documentRole) {
                if ($this->isHigherRole($userRole, $documentRole)) {
                    return false;
                }
                if ($this->isHigherOrEqualRole($userRole, $documentRole)) {
                    return true;
                }
            }
        }

        return false;
    }

    private function isHigherOrEqualRole($userRole, $documentRole)
    {
        $allRoles = Role::pluck('name')->toArray();

        $hierarchy = [
            'User' => 0,
            'Manager' => 3,
            'Admin' => 3,
            'CEO' => 4,
        ];

        foreach ($allRoles as $role) {
            if (!isset($hierarchy[$role])) {
                $hierarchy[$role] = 2;
            }
        }

        return $hierarchy[$userRole->name] >= $hierarchy[$documentRole->name];
    }

    private function isHigherRole($userRole, $documentRole)
    {
        $allRoles = Role::pluck('name')->toArray();

        $hierarchy = [
            'User' => 0,
            'Manager' => 3,
            'Admin' => 3,
            'CEO' => 4,
        ];

        foreach ($allRoles as $role) {
            if (!isset($hierarchy[$role])) {
                $hierarchy[$role] = 2;
            }
        }

        return $hierarchy[$userRole->name] > $hierarchy[$documentRole->name];
    }
}
