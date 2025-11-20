<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The name of the model.
     *
     * @var string
     */
    protected $model = \App\Models\User::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'description' => $this->faker->sentence(),
            'phone' => $this->faker->phoneNumber(),
            'code' => strtoupper(Str::random(8)),
            'website' => $this->faker->url(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'image' => null,
            'status' => $this->faker->randomElement(['active', 'inactive', 'banned']),
            'gender' => $this->faker->randomElement(['male', 'female', 'other']),
            'role' => $this->faker->randomElement(['superadmin', 'admin', 'partner', 'user']),
            'tags' => json_encode([$this->faker->word(), $this->faker->word()]),
            'wallet_id' => null,
            'remember_token' => Str::random(10),
        ];
    }
}
