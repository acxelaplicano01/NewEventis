<?php

namespace Database\Factories;

use App\Models\Publicacion;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\like>
 */
class likeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $publicacionId = Publicacion::inRandomOrder()->first()->id;
        $usuarioId = User::inRandomOrder()->first()->id;
        return [
            'meGusta' => $this->faker->boolean(),
            'noMegusta' => $this->faker->boolean(),
            'idPublicacion' => $publicacionId,
            'idUsuario' => $usuarioId,
        ];
    }
}
