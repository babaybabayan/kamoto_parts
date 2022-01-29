<?php

namespace Database\Seeders;

use App\Models\Barang;
use Illuminate\Database\Seeder;
use File;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $json = File::get("database/data/product.json");
        $model = json_decode($json);

        foreach ($model as $key => $value) {
            Barang::create([
                "code_product" => $value->code,
                "name" => $value->name,
                "id_unit" => $value->unit,
            ]);
        }
    }
}
