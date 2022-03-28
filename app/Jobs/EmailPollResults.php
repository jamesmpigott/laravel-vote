<?php

namespace App\Jobs;

use App\Models\Poll;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Notification;
use App\Notifications\PollResultsNotification;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class EmailPollResults implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        protected Poll $poll
    ) {}

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Notification::route('mail', env('NOTIFICATION_EMAIL'))
            ->notify(new PollResultsNotification($this->poll)); 
    }
}
