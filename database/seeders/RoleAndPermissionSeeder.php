<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {

        $permissionPatient = [
            'history.patient',
            'history.patient.show',
            'history.update',
            'user.get.update',
            'user.update',
        ];
        $permissionProfessional = array_merge([
            'history.professional',
            'history.professional.show',
            'history.store',
            'user.get.professional',
            'user.store',
        ], $permissionPatient);


        $professional = Role::create(['name' => 'professional']);
        $patient = Role::create(['name' => 'patient']);

        foreach ($permissionProfessional as $permission) {
            $permission = Permission::create(['name' => $permission]);
            $professional->givePermissionTo($permission);
        }

        foreach ($permissionPatient as $permission) {
            $permission = Permission::where(['name' => $permission])->first();
            $patient->givePermissionTo($permission);
        }
    }
}
