<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RoleController extends Controller
{
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $roles = Role::paginate(10);
        return view('admin.roles.index', compact('roles'));
    }

    public function create(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.roles.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|unique:roles,name',
        ]);

        Role::create([
            'uuid' => (string) Str::uuid(),
            'name' => $validated['name'],
            'guard_name' => 'web'
        ]);

        return redirect()->route('admin.roles.index')->with('success', 'Rola została stworzona pomyślnie!');
    }

    public function edit($uuid): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $role = Role::where('uuid', $uuid)->firstOrFail();
        return view('admin.roles.edit', compact('role'));
    }

    public function update(Request $request, $uuid): RedirectResponse
    {
        $role = Role::where('uuid', $uuid)->firstOrFail();
        $validated = $request->validate([
            'name' => 'required|unique:roles,name,' . $role->uuid . ',uuid',
        ]);

        $role->update([
            'name' => $validated['name']
        ]);

        return redirect()->route('admin.roles.index')->with('success', 'Rola została zaktualizowana pomyślnie!');
    }

    public function destroy($uuid): RedirectResponse
    {
        $role = Role::where('uuid', $uuid)->firstOrFail();
        $role->permissions()->detach(); // Usuwanie powiązań w tabeli `role_has_permissions`
        $role->users()->detach(); // Usuwanie powiązań w tabeli `model_has_roles`
        $role->delete();

        return redirect()->route('admin.roles.index')->with('success', 'Rola została usunięta pomyślnie!');
    }
}
