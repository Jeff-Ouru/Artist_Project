<?php

namespace Database\Factories;

use App\Models\Artwork;
use App\Models\BuyerInquiry;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<BuyerInquiry>
 */
class BuyerInquiryFactory extends Factory
{
    protected $model = BuyerInquiry::class;

    public function definition(): array
    {
        return [
            'artwork_id'      => Artwork::factory(),
            'seller_id'       => User::factory(),
            'buyer_name'      => fake()->name(),
            'buyer_email'     => fake()->safeEmail(),
            'message'         => fake()->paragraph(),
            'inquiry_type'    => fake()->randomElement(['purchase', 'provenance', 'viewing', 'advisory']),
            'dispatch_method' => fake()->randomElement(['concierge', 'email', 'app']),
            'destination'     => fake()->city() . ', ' . fake()->country(),
            'status'          => 'pending',
            'read_at'         => null,
        ];
    }
}