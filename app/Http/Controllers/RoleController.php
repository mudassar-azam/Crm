<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::where('guard_name', 'web')->get();
        return response()->json($roles);
    }

    public function show($id)
    {
        $role = Role::where('guard_name', 'web')->find($id);

        if (!$role) {
            return response()->json(['message' => 'Role not found'], 404);
        }

        return response()->json($role);
    }

    public function store(Request $request)
    {
        // Validate request data
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            // Add other validation rules as needed
        ]);

        $roleData = array_merge($request->all(), ['guard_name' => 'web']);
        $role = Role::create($roleData);

        return response()->json($role, 201);
    }

    public function update(Request $request, $id)
    {
        // Validate request data
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $id,
            // Add other validation rules as needed
        ]);

        $role = Role::where('guard_name', 'web')->find($id);

        if (!$role) {
            return response()->json(['message' => 'Role not found'], 404);
        }

        $role->update($request->all());

        return response()->json($role);
    }

    public function destroy($id)
    {
        $role = Role::where('guard_name', 'web')->find($id);

        if (!$role) {
            return response()->json(['message' => 'Role not found'], 404);
        }

        $role->delete();

        return response()->json(null, 204);
    }
}
