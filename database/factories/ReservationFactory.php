<?php

namespace Database\Factories;

use App\Models\Reservation;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservationFactory extends Factory
{
    protected $model = Reservation::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'date' => $this->faker->dateTimeBetween('+1 day', '+1 month')->format('Y-m-d'),
            'time' => $this->faker->time('H:i'),
            'party_size' => $this->faker->numberBetween(1, 10),
            'notes' => $this->faker->optional()->sentence(),
            'status' => 'pending',
        ];
    }

    public function confirmed()
    {
        return $this->state(fn () => ['status' => 'confirmed']);
    }

    public function cancelled()
    {
        return $this->state(fn () => ['status' => 'cancelled']);
    }
}
