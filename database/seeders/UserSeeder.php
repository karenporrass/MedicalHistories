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
            'document_number' => '110009394',
            'name' => 'Maria',
            'last_name' => 'Torres',
            'phone' => '312425236',
            'address' => 'Santander',
            'type' => 'professional',
            'email' => 'mariatorres11@gmail.com',
            'password' => bcrypt('110009394'),
            'remember_token' => Str::random(10),
        ]);
        $user->save();
        $user->assignRole('professional');
        $patient = new User([
            'document_number' => '101110',
            'name' => 'Ana',
            'last_name' => 'velez',
            'phone' => '57347791',
            'address' => 'Bucaramanga',
            'type' => 'patient',
            'email' => 'maria.velez@gmail.com',
            'password' => bcrypt('101110'),
            'remember_token' => Str::random(10),
        ]);
        $patient->save();
        $patient->assignRole('patient');
    }
}
