<?php

namespace Database\Seeders;

use App\Models\Reader;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Reader::create([
            'name' => 'Jan Novák',
            'email' => 'jan.novak@example.com',
        ]);

        Reader::create([
            'name' => 'Petr Svoboda',
            'email' => 'petr.svoboda@example.com',
        ]);

        Reader::create([
            'name' => 'Eva Dvořáková',
            'email' => 'eva.dvorakova@example.com',
        ]);
    }
}
