<?php

namespace App\Http\Controllers\Api;

use App\Models\Poll;
use App\Models\Option;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PollResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StorePollRequest;
use Illuminate\Contracts\Validation\Validator;

class PollController extends Controller
{
    public function index() {
        return PollResource::collection(Poll::all());
    }

    public function show(Poll $poll) {
        return new PollResource($poll);
    }

    public function create(StorePollRequest $request){
        $validated = $request->validated();
        
        $poll = Poll::create([
            'title' => $validated['title'],
            'user_id' => Auth::user()->id,
            'anon_voting' => $validated['anon_voting'],
            'geolocation_tracking' => $validated['geolocation_tracking'],
        ]);

        foreach($validated['options'] as $opt) {
            $option = Option::create([
                'value' => $opt['value'],
                'color' => $opt['color'],
                'poll_id' => $poll->id,
            ]);
        }

        return new PollResource($poll);
    }

    public function userPolls() {
        $user = Auth::user();

        return PollResource::collection(
            Poll::where('user_id', Auth::user()->id)->get()
        );
    }

    public function pollResults(Poll $poll) {
        $options = [];
        $locs = [];

        foreach($poll->options as $opt) {
            $options[] = [
                'value' => $opt->value,
                'voteCount' => $opt->votes->count()
            ];
        }

        if($poll->geolocation_tracking) {
            foreach($poll->votes as $vote) {
                if(isset($vote->geolocation['long']) && isset($vote->geolocation['lat'])) {
                    $locs[] = [
                        'coords' => [
                            (float)$vote->geolocation['long'],
                            (float)$vote->geolocation['lat']
                        ],
                        'color' => $vote->option->color,
                        'option' => $vote->option->value
                    ];
                }
            }
        }
        
        return [
            'options' => $options,
            'locs' => $poll->geolocation_tracking ? $locs : null
        ];
    }
}
