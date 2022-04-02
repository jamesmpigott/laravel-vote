<?php

namespace App\Jobs;

use App\Models\Poll;
use App\Models\Vote;
use Illuminate\Bus\Queueable;
use App\Services\IpGeolocationService;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class ProcessVote implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        protected Array $data,
        protected string $ip
    ) {}

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
        $poll = Poll::where('slug', $this->data['poll_slug'])->first();

        $location = IpGeolocationService::getLocationFromIP($this->ip);
        
        Vote::create([
            'poll_id' => $poll->id,
            'email' => $this->data['email'],
            'option_id' => $this->data['option_id'],
            'ip_address' => $this->ip,
            'geolocation' => $location
        ]);
    }
}
