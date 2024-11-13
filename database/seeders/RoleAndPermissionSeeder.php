<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'upload-image']);
        Permission::create(['name' => 'delete-image']);

        Permission::create(['name' => 'upload-supporting-documents']);
        Permission::create(['name' => 'delete-supporting-documents']);

        Permission::create(['name' => 'create-note']);
        Permission::create(['name' => 'edit-note']);
        Permission::create(['name' => 'delete-note']);

        Permission::create(['name' => 'upload-attachments']);
        Permission::create(['name' => 'delete-attachments']);

        $adminRole = Role::create([
            'name' => 'admin'
        ]);
        $dceRole = Role::create([
            'name' => 'dce'
        ]);
        $rndRole = Role::create([
            'name' => 'rnd'
        ]);

        $adminRole->givePermissionTo([
            'upload-image',
            'delete-image',
            'upload-supporting-documents',
            'delete-supporting-documents',
            'create-note',
            'edit-note',
            'delete-note',
            'upload-attachments',
            'delete-attachments',
        ]);

        $dceRole->givePermissionTo([
            'upload-image',
            'delete-image'
        ]);

        $rndRole->givePermissionTo([
            'upload-supporting-documents',
            'delete-supporting-documents',
            'upload-attachments',
            'delete-attachments',
            'create-note',
            'edit-note',
            'delete-note'
        ]);
    }
}
