<?php

namespace App;

use App\Answer;
use App\Question;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //the user can have many question hasMany
    public function questions(){
        return $this->hasMany(Question::class);
    }


     public function getUrlAttribute(){
         //return route ('questions.show',$this->id)
        return '#';
    }


    // public function setTitleAttribute($value){

    //     $this->attributes['title']=$value;
    //     $this->attributes['slug'] =  Srt::slug($value);


    // }

   //relationship model to answer model
    public function answers(){
        return $this->hasMany(Answer::class);
    }

    // public function getAvatarAttribute(){

    // }

    //relationship in answer and question table
   public function favorites()
    {
        return $this->belongsToMany(Question::class, 'favorites')->withTimestamps(); //, 'author_id', 'question_id');
    }


    //specify the table name in second arguement , eloquent will recognize that the pivot table name is for votables
    public function voteQuestions(){
        return $this->morphedByMany(Question::class,'votable');
    }

     //specify the table name in second arguement , eloquent will recognize that the pivot table name is for votables
    public function voteAnswers(){
        return $this->morphedByMany(Answer::class,'votable');
    }



    public function voteQuestion(Question $question, $vote){

        $voteQuestions = $this->voteQuestions();

        if($voteQuestions->where('votable_id',$question->id)->exists()){
            $voteQuestions->updateExistingPivot($question,['vote'=>$vote]);
        }
        else{
            $voteQuestions->attach($question,['vote'=>$vote]);
        }
        $question->load('votes');
        // $downvotes = (int) $question->votes()->wherePivot('vote',-1)->sum('vote');
        $downVotes = (int) $question->downVotes()->sum('vote');
        //   $upvotes = (int) $question->votes()->wherePivot('vote',1)->sum('vote');
        $upVotes = (int) $question->upVotes()->sum('vote');

        $question->votes_count = $upVotes + $downVotes ;
        $question->save();
    }
}
