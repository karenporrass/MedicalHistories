<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {

        $patientPermissions = [
            Permission::create(['name' => 'medical.history:read patient']),
            Permission::create(['name' => 'medical.history:update']),
            Permission::create(['name' => 'medical.user:create']),
            Permission::create(['name' => 'medical.user:read profile']),
            Permission::create(['name' => 'medical.user:update']),


        ];

        $professionalPermissions = array_merge(
            [

                Permission::create(['name' => 'medical.history:read professional']),
                Permission::create(['name' => 'medical.history:create']),
                Permission::create(['name' => 'medical.user:read']),

            ],
            $patientPermissions,

        );


        $patient = $patientPermissions;
        $rolePatient = Role::create(['name' => 'patient']);
        $rolePatient->syncPermissions($patient);

        $professional = $professionalPermissions;
        $roleProfessional = Role::create(['name' => 'professional']);
        $roleProfessional->syncPermissions($professional);
    }
}
