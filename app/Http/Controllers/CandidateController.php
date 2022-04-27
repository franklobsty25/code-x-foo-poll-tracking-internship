<?php

namespace App\Http\Controllers;

use App\Events\Votes;
use App\Models\Candidate;
use Illuminate\Http\Request;

class CandidateController extends Controller
{
    public function index() {
        $candidates = Candidate::all();

        return view('display', ['candidates' => $candidates]);
    }

    // Cast vote for candidate by passing the ballot placement number as parameter
    public function castVote($ballot) {

        $candidate = Candidate::where('ballot_placement', $ballot)->first();

        $candidate->votes += 1;

        $candidate->save();

        /**
         * Please laravel-websockets is what is used for the real time
         * poll result tracking.
        */

        Votes::dispatch();

        return back();

    }

    // Initializing the poll with candidate(s) information
    public function start() {
        request()->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'position' => 'required',
            'ballot' => 'required',
        ]);

        Candidate::create([
            'position' => request()->position,
            'ballot_placement' => request()->ballot,
            'first_name' => request()->first_name,
            'last_name' => request()->last_name,
        ]);

        return back();
    }

}
