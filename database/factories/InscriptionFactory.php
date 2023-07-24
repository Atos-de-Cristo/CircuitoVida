<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\Inscription;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Inscription>
 */
class InscriptionFactory extends Factory
{
    protected $model = Inscription::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $statusOptions = ['P', 'L'];

        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'event_id' => Event::inRandomOrder()->first()->id,
            'status' => $this->faker->randomElement($statusOptions),
            'quantity' => '1',
            'amount' => '0.00',
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
