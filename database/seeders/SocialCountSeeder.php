<?php

namespace Database\Seeders;

use App\Models\SocialCount;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SocialCountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SocialCount::factory(100000)->create();
    }
}
