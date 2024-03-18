<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Pegawai;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pegawai>
 */
class PegawaiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Pegawai::class;
    public function definition()
    {
        return [
            'nama' => fake()->name(),
            'nik' => fake()->unique()->numberBetween(1000000000, 9999999999),
            'email' => fake()->safeEmail(),
        ];
    }
}
