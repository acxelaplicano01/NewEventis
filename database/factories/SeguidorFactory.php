<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Seguidor>
 */
class SeguidorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $seguidor = User::inRandomOrder()->first()->id;
        $seguido = User::inRandomOrder()->first()->id;
        return [
            'idSeguidor' => $seguidor,
            'idSeguido' => $seguido,
        ];
    }
}
