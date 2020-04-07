<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Question;
use App\Http\Requests\AskQuestionRequest;
class QuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //  \DB::enableQueryLog();
        //now you can call the questions in you index.blade.php
        // return view('questions.index',[
        //     'questions' => Question::latest()->paginate(5)
        // ])->render();


        $questions = Question::with('user')->latest()->paginate(5);

         return view('questions.index',compact('questions'));

        // dd(\DB::getQueryLog());


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //pass the question object using compact
      $question = new Question();
        return view('questions.create',compact('question'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AskQuestionRequest $request )
    {
        //
        // dd('store'); to test if is working
        $request->user()->questions()->create($request->only('title','body')); // you can also use the all() method rather than only('','');
        return redirect()->route('questions.index')->with('success','Your Question has been submitted');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        //
        //  $question = new Question();
          return view('questions.edit',compact('question'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AskQuestionRequest $request,Question $question)
    {
        //
        $question->update($request->only('title','body'));
        return redirect()->route('questions.index')->with('success','Your question has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}