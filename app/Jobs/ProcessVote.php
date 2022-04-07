<?php

namespace App\Jobs;

use App\Models\Poll;
use App\Models\Vote;
use App\Models\Option;
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

        $local_ips = [
            '127.0.0.1',
            'localhost',
            '::1',
            '192.168.10.1'
        ];

        $ip = $this->ip;

        if(in_array($ip, $local_ips)){
            $ip = file_get_contents("http://ipecho.net/plain");
        }
        
        $location = IpGeolocationService::getLocationFromIP($ip);

        $option = Option::where('slug', $this->data['option_id'])->first();
        
        Vote::create([
            'poll_id' => $poll->id,
            'email' => $this->data['email'],
            'option_id' => $option->id,
            'ip_address' => $this->ip,
            'geolocation' => $location
        ]);
    }
}
