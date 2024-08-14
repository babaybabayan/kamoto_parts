<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Unit;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $units = array(
            [
                'name' => 'PCS',
            ],
            [
                'name' => 'SET',
            ]
        );

        foreach ($units as $unit) {
            DB::table('unit')->insert([
                'name' => $unit
            ]);
        }

    }
}
