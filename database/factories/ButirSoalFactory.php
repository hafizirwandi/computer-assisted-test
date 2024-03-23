<?php

namespace Database\Factories;

use App\Models\ButirSoal;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ButirSoal>
 */
class ButirSoalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = ButirSoal::class;
    public function definition()
    {
        return [
            'soal' => fake()->paragraph(),
            'jawaban_a' => fake()->sentence(),
            'jawaban_b' => fake()->sentence(),
            'jawaban_c' => fake()->sentence(),
            'jawaban_d' => fake()->sentence(),
            'jawaban_e' => fake()->sentence(),
            'jawaban_benar' => fake()->randomElement(['a', 'b', 'c', 'd', 'e']),
            'poin_benar' => '2.5',
            'soal_id' => '1'
        ];
    }
}
