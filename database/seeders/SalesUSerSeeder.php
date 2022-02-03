<?php

namespace Database\Seeders;

use App\Models\Sales_user;
use Illuminate\Database\Seeder;
use File;

class SalesUSerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $json = File::get("database/data/sales_user.json");
        $model = json_decode($json);
        $objcs = $model[2]->data;

        foreach($objcs as $key => $value) {
            Sales_user::create([
                'id' => $value->id,
                'code_sales' => $value->code_sales,
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
