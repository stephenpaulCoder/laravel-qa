<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Question;
use Illuminate\Http\Request;
use App\Http\Requests\CreateAnswerRequest;

class AnswersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Question $question, CreateAnswerRequest $request)
    {
        //
        $question->answers()->create([
            'body'=>$request->body,
            //save the user Id who answer by using the following code / get the current user_id
            'user_id'=> \Auth::id()]);
             return back()->with('success','Your answer has been submitted successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function show(Answer $answer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question,Answer $answer)
    {
        //
        $this->authorize('update',$answer);

        return view('answers.edit', compact('question','answer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Question $question ,Answer $answer)
    {
        //
        $this->authorize('update',$answer);

        $answer->update($request->validate([
            'body'=> 'required',
        ]));


        //this json response because of we added the answers.vue
        if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Your answer has been updated',
                    'body_html' => $answer->body_html
                ]);
            }

        return redirect()->route('questions.show', $question->slug)->with('success','Your answer has been updated');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question , Answer $answer)
    {
        //Authorize user to delete
        $this->authorize('delete',$answer);

        //Delete the answer
        $answer->delete();

        //back and display message
        return back()->with('success','Your answer has been removed');

    }
}