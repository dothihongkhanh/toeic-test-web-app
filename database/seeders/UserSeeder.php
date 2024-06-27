<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'email_verified_at' => Carbon::now(),
                'password' => bcrypt('123456789'),
                'remember_token' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'id_role' => 1,
                'google_id' => null,
            ],
            [
                'name' => 'Hồng Khánh Đỗ',
                'email' => 'dothihongkhanh22@gmai.com',
                'email_verified_at' => Carbon::now(),
                'password' => bcrypt('123456789'),
                'remember_token' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'id_role' => 2,
                'google_id' => null,
            ],
            [
                'name' => 'Hồng Khánh',
                'email' => '9377architectural@fthcapital.com',
                'email_verified_at' => Carbon::now(),
                'password' => bcrypt('123123'),
                'remember_token' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'id_role' => 2,
                'google_id' => null,
            ],
        ]);
    }
}
