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
            'user_id' => Auth::user()->id
        ]);

        foreach($validated['options'] as $opt) {
            $option = Option::create([
                'value' => $opt['value'],
                'poll_id' => $poll->id
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
}
