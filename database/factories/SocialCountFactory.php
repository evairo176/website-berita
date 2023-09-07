<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SocialCount>
 */
class SocialCountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'language' => rand(0, 1) == 1 ? "en" : "id",
            'icon' => $this->faker->city(),
            'fan_count' => $this->faker->name(),
            'fan_type' => $this->faker->country(),
            'url'    => $this->faker->url(),
            'status'    => rand(0, 1),
            'button_text'     => $this->faker->title(),
            'color'     => $this->faker->colorName(),
        ];
    }
}
