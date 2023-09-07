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
            'language' => "id",
            'icon' => $this->faker->city(),
            'fan_count' => "fan_count",
            'fan_type' => "facebook",
            'url'    => "this url",
            'status'    => 1,
            'button_text'     => "button text",
            'color'     => "color text",
        ];
    }
}
