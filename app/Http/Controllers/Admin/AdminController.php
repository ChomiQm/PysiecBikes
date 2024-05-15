<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminController extends Controller
{
    public function dashboard(Request $request): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $search = $request->input('search');

        // Paginacja i Wyszukiwanie
        $users = User::with(['userData', 'roles.permissions'])
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%')
                        ->orWhereHas('userData', function ($q) use ($search) {
                            $q->where('first_name', 'like', '%' . $search . '%')
                                ->orWhere('last_name', 'like', '%' . $search . '%')
                                ->orWhere('city', 'like', '%' . $search . '%')
                                ->orWhere('street_address', 'like', '%' . $search . '%');
                        });
                });
            })
            ->paginate(10);

        $roles = Role::all();
        $permissions = Permission::all();

        return view('admin.dashboard', compact('users', 'roles', 'permissions', 'search'));
    }

    public function assignRole(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'role' => 'required|exists:roles,name',
        ]);

        $user->assignRole($validated['role']);

        return redirect()->route('admin.dashboard')->with('success', 'Rola została przypisana pomyślnie.');
    }

    public function removeRole(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'role' => 'required|exists:roles,name',
        ]);

        $user->removeRole($validated['role']);

        return redirect()->route('admin.dashboard')->with('success', 'Rola została usunięta pomyślnie.');
    }

    public function assignPermission(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'permission' => 'required|exists:permissions,name',
        ]);

        $user->givePermissionTo($validated['permission']);

        return redirect()->route('admin.dashboard')->with('success', 'Uprawnienie zostało przypisane pomyślnie.');
    }

    public function removePermission(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'permission' => 'required|exists:permissions,name',
        ]);

        $user->revokePermissionTo($validated['permission']);

        return redirect()->route('admin.dashboard')->with('success', 'Uprawnienie zostało usunięte pomyślnie.');
    }
}
