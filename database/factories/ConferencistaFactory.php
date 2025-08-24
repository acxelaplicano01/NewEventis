<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Conferencista>
 */
class ConferencistaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $UserId = User::inRandomOrder()->first()->id;
        return [
         'Titulo' => $this->faker->sentence,
         'Descripcion' => $this->faker->paragraph,
         'Foto' => $this->faker->imageUrl(),
         'IdUser' => $UserId,
         'created_by' => 1
        ];
    }
}