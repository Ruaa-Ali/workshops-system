<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Assign to admin
        $admin = Role::findByName("admin");
        $admin->givePermissionTo([
            "manage workshops",
            "manage offerings",
            "view workshops",
            "view enrollments",
            "view stats",
            "manage users",
        ]);

        // Assign to teacher
        $teacher = Role::findByName("teacher");
        $teacher->givePermissionTo([
            "manage offerings",
            "view workshops",
            "view enrollments",
            "view stats",
        ]);

        // Assign to student
        $student = Role::findByName("student");
        $student->givePermissionTo(["view classes", "enroll to classes"]);
    }
}
