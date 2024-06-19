<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::create(['name' => 'create student']);
        Permission::create(['name' => 'read student']);
        Permission::create(['name' => 'update student']);
        Permission::create(['name' => 'delete student']);

        Permission::create(['name' => 'create counsellor']);
        Permission::create(['name' => 'read counsellor']);
        Permission::create(['name' => 'update counsellor']);
        Permission::create(['name' => 'delete counsellor']);

        Permission::create(['name' => 'create application']);
        Permission::create(['name' => 'read application']);
        Permission::create(['name' => 'update application']);
        Permission::create(['name' => 'delete application']);

        Permission::create(['name' => 'create counselling']);
        Permission::create(['name' => 'read counselling']);
        Permission::create(['name' => 'update counselling']);
        Permission::create(['name' => 'delete counselling']);

        Permission::create(['name' => 'create chat']);
        Permission::create(['name' => 'read chat']);
        Permission::create(['name' => 'update chat']);
        Permission::create(['name' => 'delete chat']);

        Permission::create(['name' => 'create payment']);
        Permission::create(['name' => 'read payment']);
        Permission::create(['name' => 'update payment']);
        Permission::create(['name' => 'delete payment']);

        Permission::create(['name' => 'create callback']);
        Permission::create(['name' => 'read callback']);
        Permission::create(['name' => 'update callback']);
        Permission::create(['name' => 'delete callback']);

        Permission::create(['name' => 'create helpdesk']);
        Permission::create(['name' => 'read helpdesk']);
        Permission::create(['name' => 'update helpdesk']);
        Permission::create(['name' => 'delete helpdesk']);

        $role = Role::create(['name' => 'super-admin']);
        $role->givePermissionTo(Permission::all());

        $role = Role::create(['name' => 'student']);
        $role->givePermissionTo([
            'create student',
            'read student',
            'update student',
            'delete student',

            'read application',
            'update application',

            'create counselling',
            'read counselling',

            'create chat',
            'read chat',
            'update chat',
            'delete chat',

            'create payment',
            'read payment',
        ]);

        $role = Role::create(['name' => 'counsellor']);
        $role->givePermissionTo([
            'create counsellor',
            'read counsellor',
            'update counsellor',
            'delete counsellor',

            'create application',
            'read application',
            'update application',
            'delete application',

            'read counselling',

            'create chat',
            'read chat',
            'update chat',
            'delete chat',
        ]);
    }
}
