<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('genders')->insert(
        [
          [
            'name' => 'HOMBRE',
            'initials' => 'H',
            'state' => true,
            'created_at' => now(),
            'updated_at' => now()
          ],
          [
            'name' => 'MUJER',
            'initials' => 'M',
            'state' => true,
            'created_at' => now(),
            'updated_at' => now()
          ]
        ]
      );
    }
}
