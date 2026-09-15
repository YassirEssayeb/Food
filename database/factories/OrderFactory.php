<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition()
    {
        $price = $this->faker->randomFloat(2, 5, 25);
        $qty = $this->faker->numberBetween(1, 5);

        return [
            'menu_item_name' => $this->faker->words(3, true),
            'price' => $price,
            'quantity' => $qty,
            'total' => $price * $qty,
            'customer_name' => $this->faker->name(),
            'customer_email' => $this->faker->safeEmail(),
            'customer_phone' => $this->faker->phoneNumber(),
            'delivery_address' => $this->faker->address(),
            'notes' => $this->faker->optional()->sentence(),
            'status' => 'pending',
        ];
    }
}
