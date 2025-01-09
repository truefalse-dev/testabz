<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Arr;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\UserPosition;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    private array $positions = [
        'Lawyer',
        'Content manager',
        'Security',
        'Designer'
    ];

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::query()->truncate();
        UserPosition::query()->truncate();

        UserPosition::factory(4)->sequence(fn ($sequence) => [
            'name' => $this->positions[$sequence->index]
        ])->create();

        User::factory(45)->create();
    }
}
