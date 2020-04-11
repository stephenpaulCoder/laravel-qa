<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Question;
use App\User;

class Answer extends Model
{
    //

    protected $fillable = ['body','user_id'];

    //first relationship method to Question to model
    public function question(){
        return $this->belongsTo(Question::class);
    }

     // relationship method to User to model
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function getBodyHtmlAttribute(){
        return \Parsedown::instance()->text($this->body);
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
    public function votes()
    {
        return $this->morphToMany(User::class, 'votable');
    }
}