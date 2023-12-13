<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use function Laravel\Prompts\text;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => fake()->name('male'),
            'last_name'=> fake()->name('male'),
            'email' => fake()->unique()->safeEmail(),
            'password' => static::$password ??= Hash::make('password'),
            'user_name'=>fake()->userName,
            'age'=>fake()->numberBetween(18,100),
            'gender'=> 'male',
            'phone_number'=>fake()->phoneNumber(),
            'address'=>fake()->text(11),
            'postal_code'=>fake()->postcode(),
            'province'=>fake()->city(),
            'city'=>fake()->city(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
