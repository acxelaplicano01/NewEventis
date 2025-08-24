<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Publicacion>
 */
class PublicacionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $usuarioId = User::inRandomOrder()->first()->id;
        return [
            'IdUsuario' => $usuarioId,
            'descripcion' => $this->faker->address(),
            'foto' => $this->faker->imageUrl(), 
            'created_by' => 1
        ];
    }
}
