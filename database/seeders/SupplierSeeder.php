<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;
use File;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $json = File::get("database/data/supplier.json");
        $model = json_decode($json);
        $objcs = $model[2]->data;

        foreach($objcs as $key => $value) {
            Supplier::create([
                'id' => $value->id,
                'code_supplier' => $value->code_supplier,
                'name' => $value->name,
                'address' => $value->address,
                'city' => $value->city,
                'telp' => $value->telp,
                'created_at' => $value->created_at,
                'updated_at' => $value->updated_at
            ]);
        }
    }
}
