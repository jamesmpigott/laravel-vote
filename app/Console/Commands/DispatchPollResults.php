<?php

namespace App\Console\Commands;

use App\Models\Poll;
use App\Jobs\EmailPollResults;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Bus;

class DispatchPollResults extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vote:dispatch-poll-results';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $polls = Poll::all();

        foreach($polls as $poll) {
            $this->info(trans("Results dispatched for :poll", ['poll' => $poll->title ]));
            dispatch(new EmailPollResults($poll));
        }
        
        return 0;
    }
}
