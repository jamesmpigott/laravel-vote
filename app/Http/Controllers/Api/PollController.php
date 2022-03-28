<?php

namespace App\Http\Controllers\Api;

use App\Models\Poll;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PollResource;

class PollController extends Controller
{
    public function index() {
        return PollResource::collection(Poll::all());
    }

    public function show(Poll $poll) {
        return new PollResource($poll);
    }
}
