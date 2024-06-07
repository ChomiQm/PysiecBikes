<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use App\Models\Permission;
use App\Models\Role; // Dodajemy import dla modelu Role
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PermissionController extends Controller
{
    public function index(Request $request): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $search = $request->input('search');

        // Filtrujemy wyniki na podstawie wyszukiwanego hasła
        $permissions = Permission::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                ->orWhereHas('roles', function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%");
                });
        })->with('roles')->paginate(10);

        return view('admin.permissions.index', compact('permissions', 'search'));
    }

    public function create(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $roles = Role::all(); // Upewniamy się, że model Role jest poprawnie zaimportowany i używany
        return view('admin.permissions.create', compact('roles'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|unique:permissions,name',
            'role_uuid' => 'required|exists:roles,uuid',
        ]);

        $permission = Permission::create([
            'uuid' => (string) Str::uuid(),
            'name' => $validated['name'],
            'guard_name' => 'web',
        ]);

        $role = Role::where('uuid', $validated['role_uuid'])->firstOrFail();
        $role->permissions()->attach($permission->uuid);

        return redirect()->route('admin.permissions.index')->with('success', 'Uprawnienie zostało stworzone pomyślnie i przypisane do roli!');
    }

    public function edit($uuid): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $permission = Permission::where('uuid', $uuid)->firstOrFail();
        return view('admin.permissions.edit', compact('permission'));
    }

    public function update(Request $request, $uuid): RedirectResponse
    {
        $permission = Permission::where('uuid', $uuid)->firstOrFail();
        $validated = $request->validate([
            'name' => 'required|unique:permissions,name,' . $permission->uuid . ',uuid',
        ]);

        $permission->update([
            'name' => $validated['name']
        ]);

        return redirect()->route('admin.permissions.index')->with('success', 'Uprawnienie zostało zaktualizowane pomyślnie!');
    }

    public function destroy($uuid): RedirectResponse
    {
        $permission = Permission::where('uuid', $uuid)->firstOrFail();
        $permission->delete();

        return redirect()->route('admin.permissions.index')->with('success', 'Uprawnienie zostało usunięte pomyślnie!');
    }
}
