<?php

namespace App\Http\Controllers;

use App\Models\Poll;
use Illuminate\Http\Request;

class PollController extends Controller
{
    public function show(Poll $poll) {
        return view('index', [
            'poll' => $poll
        ]);
    }
}
