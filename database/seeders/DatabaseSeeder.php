<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(1)->create();
        User::factory()->superAdmin()->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::factory()->create([
            'name' => 'Customer 1',
            'email' => 'customer1@gmail.com',
            'password' => bcrypt('customer123'),
            'type' => 'customer',
            'hp' => '081298765432',
            'foto_profile' => null,
            'email_verified_at' => now(),
        ]);
    }
}
