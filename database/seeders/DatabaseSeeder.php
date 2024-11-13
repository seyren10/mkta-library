<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {


        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
        ]);
        User::factory()->create([
            'name' => 'Digital Customer Experience',
            'email' => 'dce@example.com',
        ]);
        User::factory()->create([
            'name' => 'Research and Development',
            'email' => 'rnd@example.com',
        ]);

        $this->call([
            RoleAndPermissionSeeder::class
        ]);
    }
}
