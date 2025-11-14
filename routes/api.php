<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Temporary endpoint to fix production roles
// DELETE THIS AFTER USE!
Route::get('/fix-roles-emergency', function () {
    try {
        $results = [];
        
        // Check existing roles
        $roles = DB::table('roles')->select('id', 'name')->get();
        $results['existing_roles'] = $roles;
        
        // Check if superadministrator exists
        $oldRole = Role::where('name', 'superadministrator')->first();
        $newRole = Role::where('name', 'superadmin')->first();
        
        if ($oldRole && !$newRole) {
            // Rename superadministrator to superadmin
            DB::table('roles')
                ->where('name', 'superadministrator')
                ->update(['name' => 'superadmin']);
            
            // Clear cache
            app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
            
            $results['action'] = 'Renamed superadministrator to superadmin';
        } elseif ($newRole) {
            $results['action'] = 'superadmin already exists, no change needed';
        } else {
            $results['action'] = 'Neither role found, please run seeder';
        }
        
        // Get admin users
        $users = DB::table('users')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->whereIn('roles.name', ['superadmin', 'superadministrator', 'administrator'])
            ->select('users.name', 'users.email', 'roles.name as role_name')
            ->get();
        
        $results['admin_users'] = $users;
        $results['status'] = 'success';
        
        return response()->json($results);
        
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
});
