<?php

namespace Database\Seeders;

use App\Models\Barang;
use App\Models\Customer;
use App\Models\Sales_user;
use App\Models\Supplier;
use Illuminate\Database\Seeder;
use Unit;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        Customer::factory(100)->create();
        Supplier::factory(100)->create();
        Sales_user::factory(10)->create();

        $this->call([
            UnitSeeder::class,
            BarangSeeder::class
        ]);

    }
}
