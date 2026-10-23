<?php

namespace Database\Factories;

use App\Models\Artwork;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Artwork>
 */
class ArtworkFactory extends Factory
{
    protected $model = Artwork::class;

    public function definition(): array
    {
        return [
            'user_id'      => User::factory(),
            'title'        => fake()->sentence(4),
            'artist_name'  => fake()->name(),
            'year'         => fake()->numberBetween(2018, 2025),
            'inventory_no' => 'EV-' . fake()->year() . '-' . fake()->numerify('###'),
            'price_usd'    => fake()->numberBetween(5000, 100000),
            'medium'       => 'Oil on Belgian linen',
            'dimensions'   => fake()->numberBetween(80, 220) . ' × ' . fake()->numberBetween(60, 180) . ' cm',
        ];
    }
}