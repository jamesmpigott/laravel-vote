<?php

namespace App\Console\Commands;

use Faker;
use App\Models\Poll;
use App\Models\Vote;
use Illuminate\Console\Command;
use App\Services\IpGeolocationService;

class FakeVotes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vote:fake-votes 
        {poll : The slug of the poll}
        {--count=10 : Number of votes to fake}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fake votes for given poll';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $faker = Faker\Factory::create();
        
        $poll = Poll::where('slug', $this->argument('poll'))->first();
        
        $options = $poll->options;
        
        for($i=0; $i < $this->option('count'); $i++) { 
            
            $option = $options->random();
            $email = $faker->email;
            $ip = $faker->ipv4;

            $vote = Vote::create([
                'poll_id' => $poll->id,
                'option_id' => $option->id,
                'email' => $email,
                'ip_address' => $faker->ipv4,
                'geolocation' => IpGeolocationService::getLocationFromIP($ip)
            ]);

            $this->info(trans(
                "Vote for option ':option' created for :email",
                [
                    'option' => $option->value,
                    'email' => $email
                ]
            ));
        }

        return 0;
    }
}
