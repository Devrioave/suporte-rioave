<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
{
    \App\Models\User::query()->updateOrCreate(
        ['email' => 'admin@rioave.com.br'],
        [
            'name' => 'Administrador Rio Ave',
            'password' => bcrypt('rioave@2026'),
        ]
    );
}
}


