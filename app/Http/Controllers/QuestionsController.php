<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Question;
use App\User;
use App\Http\Requests\AskQuestionRequest;
class QuestionsController extends Controller
{

    public function __construct(){
        $this->middleware('auth',['except' => ['index','show']]);
    }

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
    public function show(Question $question)
    {


        //increment the views in the specific question
        $question->increment('views');

        return view('questions.show',compact('question'));


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        // authirization using gates method
        // if(\Gate::denies('update-question',$question)){
        //     //  $question = new Question();
        //       abort(403,"Access Denied");
        // }
        //   return view('questions.edit',compact('question'));


        // Authorization using Policy
        $this->authorize("update", $question);
        return view("questions.edit", compact('question'));

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
        $this->authorize("update", $question);

        $question->update($request->only('title','body'));
        return redirect()->route('questions.index')->with('success','Your question has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        //
        // Delete authorization using Gate Method
        // if(\Gate::denies('delete-question',$question)){
        //     //  $question = new Question();
        //       abort(403,"Access Denied");
        // }

        //Authorization using policy
        $this->authorize("delete", $question);
        $question->delete();
         return redirect()->route('questions.index')->with('success','Your question has been deleted');

    }
}