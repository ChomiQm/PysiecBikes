<?php

namespace App\Http\Controllers;

use App\Models\Catalog;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\Role;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('check.document.access')->only(['show', 'edit', 'update', 'destroy']);
    }

    public function create(): View|Factory|Application
    {
        $user = Auth::user();
        $roles = $user->roles->pluck('uuid')->toArray();
        $allRoles = Role::all();

        // Filtracja dokumentów na podstawie uprawnień
        $documents = $this->filterDocuments($user);

        // Tworzenie głównego katalogu
        $rootCatalog = Catalog::firstOrCreate(
            ['name' => 'documents', 'path' => 'storage/documents', 'parent_id' => null],
            ['id' => (string) Str::uuid()]
        );

        // Tworzenie katalogów dla ról, jeśli nie istnieją
        $this->createRoleCatalogs($allRoles, $rootCatalog);

        // Filtracja katalogów na podstawie uprawnień użytkownika
        $filteredCatalogs = $this->getAccessibleCatalogs($user, $allRoles);

        // Ustalenie wagi roli użytkownika
        $userRoleWeight = $this->getRoleWeight($user);
        $defaultCatalogId = null;
        if ($userRoleWeight == 2) {
            $defaultCatalog = Catalog::where('name', $user->roles->first()->name)->first();
            $defaultCatalogId = $defaultCatalog ? $defaultCatalog->id : null;
        }

        $document = new Document;
        $content = '';

        // Sprawdzenie, czy dokument ma przypisaną rolę wyższą niż rola użytkownika
        $hasHigherRole = false;
        $versions = collect(); // Pusta kolekcja wersji dokumentów

        return view('documents.editor', compact('documents', 'document', 'content', 'filteredCatalogs', 'userRoleWeight', 'defaultCatalogId', 'hasHigherRole', 'versions'));
    }

    public function edit($documentId = null): View|Factory|Application|RedirectResponse
    {
        $user = Auth::user();
        $roles = $user->roles->pluck('uuid')->toArray();
        $allRoles = Role::with('catalogs')->get();

        // Filtracja dokumentów na podstawie uprawnień
        $documents = $this->filterDocuments($user);

        // Filtracja katalogów na podstawie uprawnień użytkownika
        $filteredCatalogs = $this->getAccessibleCatalogs($user, $allRoles);

        // Ustalenie wagi roli użytkownika
        $userRoleWeight = $this->getRoleWeight($user);
        $defaultCatalogId = null;
        if ($userRoleWeight == 2) {
            $defaultCatalog = Catalog::where('name', $user->roles->first()->name)->first();
            $defaultCatalogId = $defaultCatalog ? $defaultCatalog->id : null;
        }

        $document = $documentId ? Document::findOrFail($documentId) : new Document;

        // Pobierz zawartość i odszyfruj, jeśli dokument istnieje
        if ($document->exists) {
            $version = $document->currentVersion;
            $encryptionKey = $version->encryptionKey->encryption_key;
            $encryptedContent = Storage::get($version->file_path);
            $content = decrypt($encryptedContent, $encryptionKey);
        } else {
            $content = '';
        }

        // Sprawdzenie, czy dokument ma przypisaną rolę wyższą niż rola użytkownika
        $hasHigherRole = false;
        foreach ($document->roles as $documentRole) {
            if ($this->isHigherRole($documentRole, $user->roles->first())) {
                $hasHigherRole = true;
                break;
            }
        }

        if ($hasHigherRole) {
            return redirect()->route('documents.showPdf', $document->id);
        }

        $versions = $document->versions; // Pobranie wersji dokumentu

        return view('documents.editor', compact('documents', 'document', 'content', 'filteredCatalogs', 'userRoleWeight', 'defaultCatalogId', 'hasHigherRole', 'versions'));
    }

    private function filterDocuments($user)
    {
        if ($user->hasRole('CEO')) {
            return Document::all();
        } elseif ($user->hasRole('Admin')) {
            return Document::whereDoesntHave('roles')
                ->orWhereHas('roles', function ($query) {
                    $query->where('name', 'Admin')
                        ->orWhere('name', '!=', 'CEO');
                })->get();
        } elseif ($user->hasRole('Manager')) {
            return Document::whereDoesntHave('roles')
                ->orWhereHas('roles', function ($query) {
                    $query->where('name', '!=', 'CEO');
                })->get();
        } else {
            return Document::whereHas('roles', function ($query) use ($user) {
                $roles = $user->roles->pluck('uuid')->toArray();
                $query->whereIn('roles.uuid', $roles);
            })->get();
        }
    }

    private function createRoleCatalogs($allRoles, $rootCatalog): void
    {
        foreach ($allRoles as $role) {
            if ($role->name != 'User') {
                $catalog = Catalog::firstOrCreate(
                    ['name' => $role->name, 'path' => 'storage/documents/' . $role->name, 'parent_id' => $rootCatalog->id],
                    ['id' => (string) Str::uuid()]
                );
                $catalog->roles()->syncWithoutDetaching([$role->uuid]);
            }
        }
    }

    private function canStoreInCatalog($user, $catalog): bool
    {
        $userRoles = $user->roles;
        $catalogRole = $catalog->roles->first();

        if (!$catalogRole) {
            return false;
        }

        foreach ($userRoles as $userRole) {
            if (
                $this->isHigherRole($userRole, $catalogRole) ||
                ($userRole->name === 'Admin' && $catalogRole->name === 'Admin') ||
                ($userRole->name === 'Manager' && $catalogRole->name === 'Manager') ||
                ($userRole->name === 'CEO' && $catalogRole->name === 'CEO') ||
                ($userRole->name === $catalogRole->name)
            ) {
                return true;
            }
        }

        return false;
    }

    private function isHigherRole($userRole, $documentRole): bool
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

    private function getRoleWeight($user): int
    {
        $userRole = $user->roles->first();
        $roleWeight = [
            'User' => 0,
            'Manager' => 3,
            'Admin' => 3,
            'CEO' => 4,
        ];

        // Dynamic assignment for other roles
        $allRoles = Role::pluck('name')->toArray();
        foreach ($allRoles as $role) {
            if (!isset($roleWeight[$role])) {
                $roleWeight[$role] = 2;
            }
        }

        return $roleWeight[$userRole->name] ?? 0;
    }

    private function getAccessibleCatalogs($user, $allRoles): array
    {
        $accessibleCatalogs = [];
        foreach ($allRoles as $role) {
            foreach ($role->catalogs as $catalog) {
                if ($this->canStoreInCatalog($user, $catalog)) {
                    $accessibleCatalogs[] = $catalog;
                }
            }
        }
        return $accessibleCatalogs;
    }

    public function store(Request $request, $documentId = null): RedirectResponse
    {
        $user = Auth::user();
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'required|string',
            'catalog' => 'required|uuid',
        ]);

        $catalog = Catalog::find($request->input('catalog'));

        if (!$this->canStoreInCatalog($user, $catalog)) {
            return redirect()->back()->with('error', 'Nie masz uprawnień do zapisania dokumentu w wybranym katalogu.');
        }

        if ($documentId) {
            $document = Document::findOrFail($documentId);
            $document->name = $request->input('name');
            $document->save();
        } else {
            $document = Document::create([
                'id' => (string) Str::uuid(),
                'name' => $request->input('name'),
                'created_by' => $user->id
            ]);
        }

        $version = $document->versions()->create([
            'id' => (string) Str::uuid(),
            'version_number' => $document->versions()->count() + 1,
            'file_path' => '',
            'checksum' => md5($request->input('content')),
            'created_by' => auth()->id()
        ]);

        // Szyfrowanie zawartości dokumentu przed zapisaniem
        $encryptionKey = bin2hex(random_bytes(16));
        $encryptedContent = encrypt($request->input('content'), $encryptionKey);

        $path = Catalog::generatePathForCatalog($catalog);
        Storage::put($path . '/' . $version->id . '.html', $encryptedContent);

        $version->file_path = $path . '/' . $version->id . '.html';
        $version->save();

        // Generowanie klucza szyfrowania
        $version->encryptionKey()->create([
            'encryption_key' => $encryptionKey,
            'used_at' => now(),
        ]);

        $document->current_version_id = $version->id;
        $document->save();

        // Aktualizacja relacji document_access
        $rolesToSync = [$catalog->roles->first()->uuid];
        if ($user->hasRole('CEO')) {
            $rolesToSync[] = Role::where('name', 'CEO')->first()->uuid;
        } elseif ($user->hasRole('Admin')) {
            $rolesToSync[] = Role::where('name', 'Admin')->first()->uuid;
        } elseif ($user->hasRole('Manager')) {
            $rolesToSync[] = Role::where('name', 'Manager')->first()->uuid;
        }

        // Dodanie roli docelowej
        if (!$user->hasRole($catalog->roles->first()->name)) {
            $rolesToSync[] = $catalog->roles->first()->uuid;
        }

        $document->roles()->sync($rolesToSync);

        return redirect()->route('documents.edit', ['documentId' => $document->id])->with('success', 'Dokument został zapisany.');
    }

    public function show($documentId): View|Factory|Application
    {
        $document = Document::findOrFail($documentId);
        $version = $document->currentVersion;
        $encryptionKey = $version->encryptionKey->encryption_key;
        $encryptedContent = Storage::get($version->file_path);
        $content = decrypt($encryptedContent, $encryptionKey);
        return view('documents.show', compact('document', 'content'));
    }

    public function showPdf($documentId): View|Factory|Application
    {
        $document = Document::findOrFail($documentId);
        $version = $document->currentVersion;
        $encryptionKey = $version->encryptionKey->encryption_key;
        $encryptedContent = Storage::get($version->file_path);
        $content = decrypt($encryptedContent, $encryptionKey);
        $pdf = Pdf::loadView('documents.pdf', compact('document', 'content'))->output();
        $pdfBase64 = base64_encode($pdf);
        return view('documents.show_pdf', compact('document', 'pdfBase64'));
    }

    public function destroy($documentId): RedirectResponse
    {
        $document = Document::findOrFail($documentId);
        foreach ($document->versions as $version) {
            Storage::delete($version->file_path);
            $version->delete();
        }
        $document->delete();
        return redirect()->route('documents.create')->with('success', 'Dokument został usunięty.');
    }
}
