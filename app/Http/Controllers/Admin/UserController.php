<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $roles = Role::all();
        $allowedRoles = ['all', 'admin']; // Разрешенные роли
        $role = $request->query('role', 'all');

        if (!in_array($role, $allowedRoles)) {
            return redirect()->route('admin.users.index'); // Если роль невалидная - редирект
        }

        $query = User::query();

        if ($role !== 'all') {
            $query->whereHas('roles', function ($q) use ($role) {
                if ($role === 'admin') {
                    $q->whereIn('name', ['admin', 'super_admin']);
                } else {
                    $q->where('name', $role);
                }
            });
        }

        $users = $query->paginate(20);

        return view('admin.users.index', compact('roles' ,'users'));
    }

    public function search(Request $request)
    {
        $query = $request->input('q');

        $users = User::where('name', 'LIKE', "%{$query}%")
            ->orWhere('surname', 'LIKE', "%{$query}%")
            ->orWhere('email', 'LIKE', "%{$query}%")
            ->select('id', 'name', 'surname', 'email')
            ->get();

        return response()->json($users);
    }
    public function assignRole(Request $request): JsonResponse
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|string|exists:roles,name'
        ]);

        $user = User::findOrFail($request->user_id);
        $role = $request->role;

        if ($role === 'admin' && !auth()->user()->hasRole('super_admin')) {
            return response()->json(['success' => false, 'message' => 'You do not have permission to assign this role.'], 403);
        }

        if (!$user->hasRole($role)) {
            $user->assignRole($role);
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'User already has this role.']);
    }

    public function getUserRoles(User $user): JsonResponse
    {
        $roles = $user->roles->where('name', '!=', 'super_admin')->values();
        return response()->json(['roles' => $roles]);
    }

    public function removeUserRole(User $user, $role): JsonResponse
    {
        if ($role === 'admin' && !Auth::user()->hasRole('super_admin')) {
            return response()->json(['error' => 'Only super admins can remove Admin role'], 403);
        }

        $user->removeRole($role);

        return response()->json(['success' => true]);
    }

    public function destroy(User $user)
    {
        $fullName = "<b>" . e($user->name . ' ' . $user->surname) . "</b>";
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', "User $fullName has been deleted!");
    }

}
