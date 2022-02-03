<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;
use File;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $json = File::get("database/data/customer.json");
        $model = json_decode($json);
        $objcs = $model[2]->data;

        foreach($objcs as $key => $value) {
            Customer::create([
                'id' => $value->id,
                'code_customer' => $value->code_customer,
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
