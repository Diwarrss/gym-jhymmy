<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('states')->insert(
        [
          [
            'name' => 'Activo',
            'created_at' => now(),
            'updated_at' => now()
          ],
          [
            'name' => 'Inactivo',
            'created_at' => now(),
            'updated_at' => now()
          ]
        ]
      );
    }
}
