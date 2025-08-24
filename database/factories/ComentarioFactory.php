<?php

namespace Database\Factories;

use App\Models\Publicacion;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comentario>
 */
class ComentarioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $usuarioId = User::inRandomOrder()->first()->id;
        $publicacionId = Publicacion::inRandomOrder()->first()->id;
        return [
            'IdPublicacion' => $publicacionId,
            'TextComentario' => $this->faker->text(),
            'imagen' => $this->faker->imageUrl(),
            'created_by' => $usuarioId,
        ];
    }
}
