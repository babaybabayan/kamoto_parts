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
        $json = File::get("database/data/product_name.json");
        $model = json_decode($json);
        $objcs = $model[2]->data;

        foreach($objcs as $key => $value) {
            Barang::create([
                'id' => $value->id,
                'code_product' => $value->code_product,
                'name' => $value->name,
                'id_unit' => $value->id_unit,
                'created_at' => $value->created_at,
                'updated_at' => $value->updated_at
            ]);
        }
    }
}
