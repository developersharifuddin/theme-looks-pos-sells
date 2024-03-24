<?php

namespace Database\Factories;

use App\Models\ItemInfo;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemInfoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ItemInfo::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'slug' => $this->faker->slug,
            'code' => $this->faker->unique()->randomNumber(),
            'sku' => $this->faker->unique()->randomNumber(),
            'unit' => "KG",
            'unit_value' => "1-KG",
            'published_price' => 1000,
            'purchase_price' => 700,
            'sell_price' => 900,
            'discount_type' => 10,
            'discount_amount' => 100,
            'tax' => 5,
            'tax_amount' => 50,
            'current_stock' => $this->faker->numberBetween(5, 1000),
            'min_qty' => 1,
            'thumbnail' => 'default.png',
            'stock_status' => 1,
            'approved_status' => true,
            'is_published' => true,
            'status' => true,
        ];
    }
}
