<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate([
            "email" => "adm@teste.com.br"
        ],[
            "name" => "Administrador",
            "email" => "adm@teste.com.br",
            "password" => "randomPassword123",
            "role" => "admin"
        ]);
        User::factory()->count(10)->create();
    }
}
