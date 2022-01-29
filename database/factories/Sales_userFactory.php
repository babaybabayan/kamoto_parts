<?php

namespace Database\Factories;

use App\Models\Sales_user;
use Illuminate\Database\Eloquent\Factories\Factory;

class Sales_userFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Sales_user::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'code_sales' => $this->faker->ean13(),
            'name' => $this->faker->firstName(),
            'address' => $this->faker->address(),
            'city' => $this->faker->city(),
            'telp' => $this->faker->PhoneNumber()
        ];
    }
}
