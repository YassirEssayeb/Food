<?php

namespace Database\Factories;

use App\Models\MenuItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class MenuItemFactory extends Factory
{
    protected $model = MenuItem::class;

    public function definition()
    {
        return [
            'name' => $this->faker->unique()->words(3, true),
            'description' => $this->faker->sentence(),
            'price' => $this->faker->randomFloat(2, 3, 25),
            'category' => $this->faker->randomElement(['Burgers', 'Sides', 'Drinks', 'Desserts', 'Pasta', 'Salads', 'Chicken & Wraps']),
            'image' => 'https://images.unsplash.com/photo-1550547660-d9450f859349?w=800',
            'is_special' => $this->faker->boolean(30),
            'ingredients' => $this->faker->sentence(6),
            'allergens' => $this->faker->randomElement(['Dairy, Gluten', 'None', 'Dairy, Gluten, Eggs', 'Nuts']),
        ];
    }

    public function special()
    {
        return $this->state(fn () => ['is_special' => true]);
    }

    public function category(string $category)
    {
        return $this->state(fn () => ['category' => $category]);
    }
}
