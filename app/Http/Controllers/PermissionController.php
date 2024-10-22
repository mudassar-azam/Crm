<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{


    public function refresh()
    {
        \App\Models\Permission::query()->where('guard_name', 'web')->delete(); 

        $routes = collect(Route::getRoutes())->filter(function ($route) {
            return $route->getPrefix() === '';
        })->map(function ($route) {
            return $route->getName();
        })->filter();



        foreach ($routes as $routeName) {
            DB::table('permissions')->insert([
                'route' => $routeName,
                'guard_name' => 'web',
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Successfully added all permission URLs.'
        ]);
    }


    public function index()
    {
        $permissions = Permission::all();
        if ($permissions) {
            return response()->json([
                'success' => true,
                'permissions' => ['data' => $permissions],
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'not found '
            ]);
        }
    }

    public function store(Request $request)
    {

        $validatedData =  Validator::make($request->all(), [
            'name' => 'required|unique:permissions,name',
        ], [
            'name.required' => 'Name is required.',
        ]);

        if ($validatedData->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validatedData->errors()->first()
            ]);
        }
        $permission = Permission::create([
            'name' => $request->name,
        ]);

        return response()->json(['message' => 'Permission created successfully', 'data' => $permission], 201);
    }

    public function show(Permission $permission)
    {
        return response()->json(['data' => $permission]);
    }

    public function update(Request $request, $id)
    {

        $permissionn = Permission::find($id);

        if ($permissionn) {
            $validatedData =  Validator::make($request->all(), [
                'name' => 'required|unique:permissions,name,' . $id,
            ], [
                'name.required' => 'Name is required.',
            ]);
            if ($validatedData->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validatedData->errors()->first()
                ]);
            }

            $permissionn->update([
                'name' => $request->name,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'updated successfully '
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'not found '
            ]);
        }
    }

    public function destroy(Request $request)
    {
        $permissionData = Permission::find($request->id);
        if ($permissionData) {
            $permissionData->delete();

            return response()->json([
                'success' => true,
                'message' => 'deleted successfully '
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'not found '
            ]);
        }
    }
    public function getPermissionsByRole($roleId)
    {
        $role = Role::find($roleId);
        if ($role) {
            $permissions = $role->permissions;

            return response()->json([
                'success' => true,
                'permissions' => $permissions
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'not found '
            ]);
        }
    }
}
