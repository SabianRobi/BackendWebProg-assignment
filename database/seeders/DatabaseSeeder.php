<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use App\Models\Label;
use App\Models\Item;
use App\Models\Comment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $userCount = rand(10, 20);
        $labelCount = rand(10, 20);
        $itemCount = rand(13, round($userCount*2));
        $commentCount = rand(round($userCount*0.75), round($userCount*2));

        //Users
        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@szerveroldali.hu',
            'password' => Hash::make('admin'),
            'is_admin' => true,
        ]);
        for ($i=1; $i < $userCount+1; $i++) { 
            User::factory()->create([
                'name' => 'user'. $i,
                //'name' => fake()->name(),
                'email' => 'user' . $i . '@szerveroldali.hu',
                'password' => Hash::make('password')
            ]);
        }

        //Labels
        $labels = Label::factory($labelCount)->create();

        //Items
        $items = Item::factory($itemCount)->create();

        //Comments
        Comment::factory($commentCount)->create();

        //Relations between items and labels
        $items->each(function ($item) use (&$labels, &$labelCount) {
            $labelIds = $labels
            ->random(rand(1, $labelCount/3))
            ->pluck('id')
            ->toArray();
            $item->labels()->sync($labelIds);
        });
    }
}
