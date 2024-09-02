<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\customer>
 */
class CustomerFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    return [
      'name' => $this->faker->name(),
      'email' => $this->faker->unique()->safeEmail(),
      'phone' => $this->faker->tollFreePhoneNumber(),
      'address' => $this->faker->streetAddress(),
      'city' => $this->faker->city(),
      'region' => $this->faker->state(),
      'country' => 'US',
      'postal_code' => $this->faker->postcode(),
    ];
  }
}
