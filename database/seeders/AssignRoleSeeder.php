<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AssignRoleSeeder extends Seeder
{
    public function run(): void
    {
        if ($admin = User::where('email', 'admin@gmail.com')->first()) {
            $admin->syncRoles(['admin']);
        }

        if ($audit = User::where('email', 'audit@gmail.com')->first()) {
            $audit->syncRoles(['audit']);
        }
    }
}