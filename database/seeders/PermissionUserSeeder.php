<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role_admin = Role::create(['name' => 'ADMINISTRATOR']);
        $role_kasir = Role::create(['name' => 'KASIR']);
        $role_member = Role::create(['name' => 'MEMBERSHIP']);

        // $rols_founder = Role::create(['name' => 'FOUNDER']);

        // Permissions member
        $member_view = Permission::create(['name' => 'member view']);
        $member_create = Permission::create(['name' => 'member create']);
        $member_update = Permission::create(['name' => 'member update']);
        $member_delete = Permission::create(['name' => 'member delete']);
        $member_restore = Permission::create(['name' => 'member restore']);

        // Permissions paket
        $paket_view = Permission::create(['name' => 'paket view']);
        $paket_create = Permission::create(['name' => 'paket create']);
        $paket_update = Permission::create(['name' => 'paket update']);
        $paket_delete = Permission::create(['name' => 'paket delete']);
        $paket_restore = Permission::create(['name' => 'paket restore']);

        // Permissions paket
        $transaksi_view = Permission::create(['name' => 'transaksi view']);
        $transaksi_create = Permission::create(['name' => 'transaksi create']);
        $transaksi_update = Permission::create(['name' => 'transaksi update']);

        // Permissions Report
        $report_member_view = Permission::create(['name' => 'report member view']);
        $report_transaksi_view = Permission::create(['name' => 'report transaksi view']);


        // Set Permissions to admin
        $permissions_admin = [
            $member_view, $member_restore, $member_update,
            $paket_view, $paket_create, $paket_update, $paket_delete, $paket_restore
        ];

        // Set Permissions to kasir
        // $permissions_kasir = [
        //     $paket_view,
        //     $member_view, $member_delete, $member_update, $member_create,
        //     $transaksi_view, $transaksi_create, $transaksi_update,
        //     $report_member_view, $report_transaksi_view
        // ];

        // Set Permissions to Founder
        // $permissions_founder = [
        //     $paket_view, $paket_create, $paket_update,
        //     $member_view,
        //     $transaksi_view,
        //     $report_member_view, $report_transaksi_view
        // ];

        $role_admin->syncPermissions($permissions_admin);
        // $role_kasir->syncPermissions($permissions_kasir);
        // $rols_founder->syncPermissions($permissions_founder);

        $user = \App\Models\User::factory()->create([
            'name' => 'Administrator',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password123')
        ]);
        $user->assignRole($role_admin);

        // $user = \App\Models\User::factory()->create([
        //     'name' => 'Kasir Gym',
        //     'email' => 'kasir@kasir.com',
        // ]);
        // $user->assignRole($role_kasir);

        // $user = \App\Models\User::factory()->create([
        //     'name' => 'Founder',
        //     'email' => 'founder.gym@founder.com',
        // ]);
        // $user->assignRole($rols_founder);

    }
}
