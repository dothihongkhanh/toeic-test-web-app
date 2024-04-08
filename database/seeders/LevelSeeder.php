<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('levels')->insert([
            [
                'name_level' => '450 +'
            ],
            [
                'name_level' => '600 +'
            ],
            [
                'name_level' => '850 +'
            ],

        ]);
    }
}
