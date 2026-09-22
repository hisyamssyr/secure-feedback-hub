<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FeedbackFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->numerify('##########').'@student.its.ac.id',
            'category' => fake()->randomElement(['Akademik', 'Sarana Prasarana', 'Kegiatan Mahasiswa']),
            'message' => fake()->paragraph(),
        ];
    }
}
