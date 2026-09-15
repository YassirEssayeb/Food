<?php

namespace Database\Factories;

use App\Models\FoodReview;
use App\Models\MenuItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class FoodReviewFactory extends Factory
{
    protected $model = FoodReview::class;

    public function definition()
    {
        return [
            'menu_item_name' => MenuItem::count() ? MenuItem::inRandomOrder()->first()->name : $this->faker->word(),
            'user_name' => $this->faker->name(),
            'comment' => $this->faker->paragraph(2),
            'rating' => $this->faker->numberBetween(1, 5),
        ];
    }
}
