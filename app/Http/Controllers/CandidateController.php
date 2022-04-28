<?php

namespace App\Http\Controllers;

use App\Events\Votes;
use App\Models\Candidate;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Session;

class CandidateController extends Controller
{
    public function index() {
        try {
        $candidates = Candidate::all();

        return view('display', ['candidates' => $candidates]);
        } catch (QueryException $e) {
            echo 'Candidates table does not exist. Please run php artisan migrate.';
            return;
        }
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
            'ballot' => 'required|integer|min:1',
        ]);

        try {

        Candidate::create([
            'position' => Str::ucfirst(request()->position),
            'ballot_placement' => request()->ballot,
            'first_name' => Str::ucfirst(request()->first_name),
            'last_name' => Str::ucfirst(request()->last_name),
        ]);

        return back();

        } catch (QueryException $e) {
            Session::flash('error', 'Ballot position already exists.');
            return back();
        }
    }

}
