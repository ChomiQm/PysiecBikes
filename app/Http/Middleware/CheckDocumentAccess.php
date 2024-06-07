<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Document;
use Spatie\Permission\Models\Role;

class CheckDocumentAccess
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        $documentId = $request->route('documentId');

        $document = Document::find($documentId);

        if (!$document) {
            return response()->json(['message' => 'Document not found'], 404);
        }

        if ($user->hasRole('CEO')) {
            return $next($request);
        }

        if ($document->roles->isEmpty()) {
            return $next($request);
        }

        if ($user->roles->isEmpty()) {
            return response()->json(['message' => 'Unauthorized - no roles assigned'], 403);
        }

        if ($this->hasAccess($user, $document)) {
            return $next($request);
        }

        return response()->json(['message' => 'Unauthorized'], 403);
    }

    private function hasAccess($user, $document)
    {
        $userRoles = $user->roles;
        $documentRoles = $document->roles;

        if ($userRoles->intersect($documentRoles)->isNotEmpty()) {
            return true;
        }

        foreach ($userRoles as $userRole) {
            foreach ($documentRoles as $documentRole) {
                if ($this->isHigherRole($userRole, $documentRole)) {
                    return true;
                }
            }
        }

        return false;
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

        //inne role na 2
        foreach ($allRoles as $role) {
            if (!isset($hierarchy[$role])) {
                $hierarchy[$role] = 2;
            }
        }

        return $hierarchy[$userRole->name] > $hierarchy[$documentRole->name];
    }
}
