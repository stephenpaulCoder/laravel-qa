<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Question;

class VoteQuestionController extends Controller
{
    //

    public function __construct(){
        $this->middleware('auth');
    }

    public function __invoke(Question $question){
        //make sure the vote is interger by (int)
        $vote = (int) request()->vote;

       // we need to get the current user by auth then call the user method to get user instance and the voteQUestion
       //pass the question instance and vote instance in second arguement and refresh the page by calling bakc.

       auth()->user()->voteQuestion($question,$vote);

       return back();


    }
}