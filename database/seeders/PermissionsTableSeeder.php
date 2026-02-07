<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Carbon;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();

        $perms = [
            ['name' => 'manage_users', 'guard_name' => 'web', 'description' => 'Create/update/delete users', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'manage_roles', 'guard_name' => 'web', 'description' => 'Create/update/delete roles', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'manage_permissions', 'guard_name' => 'web', 'description' => 'Create/update/delete permissions', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'manage_students', 'guard_name' => 'web', 'description' => 'Manage student records', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'manage_teachers', 'guard_name' => 'web', 'description' => 'Manage teacher records', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'manage_classes', 'guard_name' => 'web', 'description' => 'Manage classes and sections', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'view_reports', 'guard_name' => 'web', 'description' => 'View system reports', 'created_at' => $now, 'updated_at' => $now],
        ];

        DB::table('permissions')->insertOrIgnore($perms);

        // assign baseline permissions: super_admin gets all, school_admin gets a subset
        $permissions = DB::table('permissions')->pluck('id')->toArray();
        $roles = DB::table('roles')->pluck('id', 'name');

        if (isset($roles['super_admin'])) {
            $pairs = array_map(function ($pid) use ($roles) {
                return ['permission_id' => $pid, 'role_id' => $roles['super_admin']];
            }, $permissions);
            DB::table('role_has_permissions')->insertOrIgnore(array_map(function ($p) {
                return array_merge($p, ['created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
            }, $pairs));
        }

        if (isset($roles['school_admin'])) {
            $allowed = DB::table('permissions')->whereIn('name', ['manage_users','manage_classes','view_reports','manage_students'])->pluck('id')->toArray();
            $pairs = array_map(function ($pid) use ($roles) {
                return ['permission_id' => $pid, 'role_id' => $roles['school_admin']];
            }, $allowed);
            DB::table('role_has_permissions')->insertOrIgnore(array_map(function ($p) {
                return array_merge($p, ['created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
            }, $pairs));
        }
    }
}
