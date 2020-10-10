<?php
namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     *
     *
     *
     *
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Admin Admin',
            'identification' => '1101000000',
            'address' => 'calle falsa 123',
            'phone' => '3001234567',
            'birthdate' => now(),
            'email' => 'admin@argon.com',
            'email_verified_at' => now(),
            'password' => Hash::make('secret'),
            'pin' => '1234',
            'state_id' => '1',
            'gender_id' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
