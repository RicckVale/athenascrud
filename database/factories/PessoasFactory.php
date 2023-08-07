<?php

namespace Database\Factories;

use App\Models\Pessoas;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Clientes>
 */
class PessoasFactory extends Factory
{
    protected $model = Pessoas::class;


    /**
     * Get a new Faker instance.
     *
     * @return \Faker\Generator
     */
    public function withFaker()
    {
        return \Faker\Factory::create('pt_BR');
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome' => $this->faker->name,
            'cpf' => "111.111.111-11",
            'email' => $this->faker->unique()->safeEmail,
            'categoria' => rand(1, 3),
        ];
    }
}
