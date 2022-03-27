<?php

namespace App\Http\Controllers\Api;

use App\Models\Poll;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVoteRequest;
use Illuminate\Support\Facades\Validator;

class VoteController extends Controller
{
    public function processVote(StoreVoteRequest $request) { }
}
