<?php

namespace Database\Factories;

use App\Models\supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

class supplierFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = supplier::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'code_supplier' => $this->faker->ean13(),
            'name' => $this->faker->firstName(),
            'address' => $this->faker->address(),
            'city' => $this->faker->city(),
            'telp' => $this->faker->PhoneNumber()
        ];
    }
}
