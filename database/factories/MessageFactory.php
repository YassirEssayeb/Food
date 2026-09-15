<?php

namespace Database\Factories;

use App\Models\Message;
use Illuminate\Database\Eloquent\Factories\Factory;

class MessageFactory extends Factory
{
    protected $model = Message::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->safeEmail(),
            'subject' => $this->faker->optional()->sentence(4),
            'message' => $this->faker->paragraph(3),
            'is_read' => false,
        ];
    }

    public function read()
    {
        return $this->state(fn () => ['is_read' => true]);
    }
}
