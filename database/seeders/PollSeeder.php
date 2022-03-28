<?php

namespace Database\Seeders;

use App\Models\Poll;
use App\Models\Option;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PollSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $poll = Poll::create([
            'title' => "What's your favorite Star Wars Character?",
            'slug' => Str::random()
        ]);

        $options = [
            "Han Solo",
            "Luke Skywalker",
            "Darth Vader",
            "Chewbacca",
            "Boba Fett",
            "Din Djarin / The Mandalorian",
            "Yoda"
        ];

        foreach ($options as $option) {
            Option::create([
                'value' => $option,
                'poll_id' => $poll->id
            ]);
        }
        
        $this->command->info(
            trans("Poll ':name' created!", ['name' => $poll->title])
        );

        $this->command->info(
            trans("Poll is viewable at this url: :url", [
                'url' => route('poll.show', $poll)
            ])
        );
    }
}
