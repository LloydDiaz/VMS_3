<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Violatuon;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\GeographySeeder;
use Database\Seeders\TicketCounterSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'firstname' => 'Lloyd Neil',
            'lastname' => 'Diaz',
            'middlename' => 'Perez',
            'user_role' => 'admin',
            'username' => 'Neilriz28',
            'email' => 'lloyd.niel.diaz@gmail.com',
            'password' => Hash::make('Neilriz@28'),
        ]);

        $this->call([
            GeographySeeder::class,
        ]);
    }
}
