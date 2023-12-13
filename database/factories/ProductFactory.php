<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_name'=>fake()->text(11),
            'price'=>fake()->numberBetween(0 , 100000000),
            'amount_available'=>fake()->numberBetween(0 , 10000),
            'sold_number'=>fake()->numberBetween( 0 , 9999),
            'explanation'=>fake()->text(11),
        ];
    }
}
