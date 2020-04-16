<?php

namespace App;

use App\Question;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Yansongda\LaravelParsedown\Facades\Parsedown;

class Answer extends Model
{
    //
    use VotableTrait;
    protected $fillable = ['body','user_id'];

    protected $appends = ['created_date','body_html'];

    //first relationship method to Question to model
    public function question(){
        return $this->belongsTo(Question::class);
    }

     // relationship method to User to model
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function getBodyHtmlAttribute(){
        return clean(Parsedown::instance()->text($this->body));
    }

    public static function boot(){
            parent::boot();

            //Increment the answer count from the database
            static::created(function($answer){
                $answer->question->increment('answers_count');

            });
            //decrement the answer count from the database
            static::deleted(function($answer){

                // $question = $answer->question;
                // $question->question->decrement('answers_count');

                //We use database Eloquent ( foreign key )
                $answer->question->decrement('answers_count');


                // if($question->best_answer_id == $answer->id){
                //     $question->best_answer_id = NULL;
                //     $question->save();
                // }
            });


    }

    public function getCreatedDateAttribute(){
        return $this->created_at->diffForHumans();
    }

    public function getStatusAttribute(){
        return $this->isbest() ? 'vote-accepted' : '' ;
    }


    public function getIsBestAttribute(){
        return $this->isBest();
    }

     public function isBest(){
        return $this->id == $this->question->best_answer_id;
    }

    //first relationship method in votable and second arguemnet for the pivot table name
    //refreactor the code and paste in votabletrait.php
    // public function votes()
    // {
    //     return $this->morphToMany(User::class, 'votable');
    // }

    // public function upVotes(){
    //     return $this->votes()->wherePivot('vote',1);
    // }

    //   public function downVotes(){
    //     return $this->votes()->wherePivot('vote',-1);
    // }


    // public function voteAnswer(Answer $answer , $vote){
    //     $voteAnswers = $this->voteAnswers();

    //     if($voteAnswers->where('votable_id',$answer->id)->exists()){
    //         $voteAnswers->updateExistingPivot($answer,['vote'=>$vote]);
    //     }
    //     else{
    //         $voteAnswers->attach($answer,['vote'=>$vote]);
    //     }
    //     $answer->load('votes');
    //     // $downvotes = (int) $question->votes()->wherePivot('vote',-1)->sum('vote');
    //     $downVotes = (int) $answer->downVotes()->sum('vote');
    //     //   $upvotes = (int) $question->votes()->wherePivot('vote',1)->sum('vote');
    //     $upVotes = (int) $answer->upVotes()->sum('vote');

    //     $answer->votes_count = $upVotes + $downVotes ;
    //     $answer->save();
    // }
}
