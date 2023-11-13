<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Item;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $user = User::find(rand(1, User::count()));
        $item = Item::find(rand(1, Item::count()));
        return [
            'text' => fake()->realText(),
            'item_id' => $item->id,
            'user_id' => $user->id
        ];
    }
}
