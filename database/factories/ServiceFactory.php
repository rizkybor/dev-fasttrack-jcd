<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->words(3, true);
        return [
            'name' => ucwords($name),
            'slug' => \Illuminate\Support\Str::slug($name),
            'description' => $this->faker->paragraph(3),
            'price' => $this->faker->randomElement([1500000, 2500000, 3500000, 5000000]),
            'meta_title' => 'Jasa ' . ucwords($name) . ' Terpercaya',
            'meta_description' => $this->faker->sentence(10),
        ];
    }
}
