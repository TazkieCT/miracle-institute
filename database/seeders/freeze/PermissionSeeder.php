<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use Illuminate\Support\Str;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        $permissions = [

            // USER
            'manage_users',

            // COURSE SYSTEM
            'manage_courses',
            'manage_topics',
            'access_topic',

            // LEARNING
            'enroll_course',
            'take_assessment',

            // ASSESSMENT
            'manage_assessments',

            // CERTIFICATE
            'manage_certificates',

            // REPORT
            'view_reports',
        ];

        foreach ($permissions as $perm) {
            Permission::create([
                'id' => Str::uuid(),
                'name' => $perm
            ]);
        }
    }
}
