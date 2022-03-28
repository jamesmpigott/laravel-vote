<?php

namespace App\Console\Commands;

use App\Models\Poll;
use App\Models\Option;
use Illuminate\Support\Str;
use Illuminate\Console\Command;

class AddPoll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vote:add-poll';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add Poll with given options';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $title = $this->ask('Please enter the title of the poll:');
        
        $options = [];

        $optionCount = $this->ask('Please enter the number of options for this poll:', 2);

        for ($i=0; $i < (int) $optionCount; $i++) { 
            $options[$i] = $this->ask(
                __("Please enter a value for option :count", 
                    [
                        'count' => $i + 1
                    ]
                ));
        }

        $poll = Poll::create([
            'title' => $title,
            'slug' => Str::random()
        ]);

        foreach ($options as $inputOption) {
            $option = Option::create([
                'value' => $inputOption,
                'poll_id' => $poll->id
            ]);
        }

        $this->info(
            __("Poll: :title created", [
                'title' => $poll->title
            ])
        );

        $this->info(
            __("Poll is viewable at this url: :url", [
            'url' => route('poll.show', $poll)
            ])
        );

        return 0;
    }
}
