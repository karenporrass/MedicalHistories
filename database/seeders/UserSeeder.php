<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{

    public function run()
    {
        $user = new User([
            'document_number' => '1093221111',
            'name' => 'David',
            'last_name' => 'Torres',
            'phone' => 'Torres',
            'address' => 'Torres',
            'type' => 'professional',
            'email' => 'fernando.zapata.live@gmail.com',
            'password' => bcrypt('12345678'),
            'remember_token' => Str::random(10),
        ]);
        $user->save();
        $user->assignRole('professional');
        $patient = new User([
            'document_number' => '1011',
            'name' => 'maria',
            'last_name' => 'velez',
            'phone' => '111',
            'address' => '111',
            'type' => 'patient',
            'email' => 'maria.zapa@gmail.com',
            'password' => bcrypt('12345'),
            'remember_token' => Str::random(10),
        ]);
        $patient->save();
        $patient->assignRole('professional');
    }
}
