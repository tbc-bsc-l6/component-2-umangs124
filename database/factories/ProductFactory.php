<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => Str::random(rand(5,6)),
            'price' => $this->faker->numberBetween($min = 15, $max = 100),
            'description' => $this->faker->paragraph(1),
            'product_type_id' => random_int(1, 3),
        ];
    }
}
