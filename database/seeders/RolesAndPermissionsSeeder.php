<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'manage-users',
            'manage-courses',
            'manage-programs',
            'manage-packages',
            'create-courses',
            'view-own-courses',
            'browse-courses',
            'enroll',
            'view-my-courses',
            'cancel-enrollment',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        $admin = Role::firstOrCreate(['name' => 'admin']);
        $teacher = Role::firstOrCreate(['name' => 'teacher']);
        $student = Role::firstOrCreate(['name' => 'student']);

        $admin->syncPermissions(Permission::all());
        $teacher->syncPermissions(['create-courses', 'view-own-courses']);
        $student->syncPermissions(['browse-courses', 'enroll', 'view-my-courses', 'cancel-enrollment']);
    }
}