<?php

namespace Database\Factories;

use App\Models\Siswa;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Siswa>
 */
class SiswaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Siswa::class;
    public function definition()
    {
        return [
            'nama' => fake()->name(),
            'nis' => fake()->unique()->numberBetween(1000000000, 9999999999),
            'email' => fake()->safeEmail(),
        ];
    }
}
