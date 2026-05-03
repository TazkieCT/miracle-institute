<?php

namespace Database\Seeders\Auth;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        /*
         |-------------------------------------------------------------
         | Testing credentials:
         | 1) Admin     : admin@example.test    / Password123!
         | 2) Disciple  : disciple@example.test / Password123!
         | 3) Student   : student@example.test  / Password123!
         |-------------------------------------------------------------
         */

        $admin = User::factory()->create([
            'first_name' => 'System',
            'last_name' => 'Admin',
            'email' => 'admin@example.test',
            'password' => Hash::make('Password123!'),
            'email_verified_at' => now(),
        ]);

        $disciples = User::factory()->create([
            'first_name' => 'Grace',
            'last_name' => 'Disciple',
            'email' => 'disciple@example.test',
            'password' => Hash::make('Password123!'),
            'email_verified_at' => now(),
        ]);

        $student = User::factory()->create([
            'first_name' => 'Alex',
            'last_name' => 'Student',
            'email' => 'student@example.test',
            'password' => Hash::make('Password123!'),
            'email_verified_at' => now(),
        ]);

        $adminRole = Role::where('name', 'admin')->first();
        $studentRole = Role::where('name', 'student')->first();
        $disciplesRole = Role::where('name', 'disciples')->first();

        if ($adminRole) {
            $admin->roles()->attach($adminRole->id, ['assigned_at' => now()]);
        }

        if ($studentRole && $disciplesRole) {
            $disciples->roles()->attach([
                $studentRole->id => ['assigned_at' => now()],
                $disciplesRole->id => ['assigned_at' => now()],
            ]);
        } elseif ($studentRole) {
            $disciples->roles()->attach($studentRole->id, ['assigned_at' => now()]);
        }

        if ($studentRole) {
            $student->roles()->attach($studentRole->id, ['assigned_at' => now()]);
        }

        // Additional dummy users for testing lists / pagination
        User::factory()->count(8)->student()->create()->each(function (User $user) use ($studentRole) {
            if ($studentRole) {
                $user->roles()->attach($studentRole->id, ['assigned_at' => now()]);
            }
        });

        User::factory()->count(2)->disciples()->create()->each(function (User $user) use ($studentRole, $disciplesRole) {
            $attach = [];

            if ($studentRole) {
                $attach[$studentRole->id] = ['assigned_at' => now()];
            }
            if ($disciplesRole) {
                $attach[$disciplesRole->id] = ['assigned_at' => now()];
            }

            $user->roles()->attach($attach);
        });
    }
}