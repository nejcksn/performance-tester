<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function list(Request $request): JsonResponse
    {
        $roles = Role::query();

        if (!auth()->user()->hasRole('super_admin')) {
            $roles->where('name', '!=', 'admin');
        }

        return response()->json($roles->select('name')->get());
    }
}
