<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $map = [
            'admin' => [
                'manage_users',
                'manage_courses',
                'manage_topics',
                'manage_assessments',
                'manage_certificates',
                'view_reports',
            ],
            'instructor' => [
                'manage_topics',
                'manage_assessments',
                'view_reports',
            ],
            'student' => [
                'enroll_course',
                'access_topic',
                'take_assessment',
            ],
            'disciples' => [
                'access_topic',
            ],
        ];

        foreach ($map as $roleName => $permissions) {
            $role = Role::where('name', $roleName)->first();

            if (!$role) continue;

            $permissionIds = Permission::whereIn('name', $permissions)
                ->pluck('id')
                ->toArray();

            $role->permissions()->sync($permissionIds);
        }
    }
}