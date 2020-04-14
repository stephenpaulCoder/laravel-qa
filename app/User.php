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


    protected $appends = ['url'];
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
        $this->_vote($voteQuestions,$question,$vote);
    }

     public function voteAnswer(Answer $answer , $vote){
        $voteAnswers = $this->voteAnswers();
        $this->_vote($voteAnswers,$answer,$vote);
    }

    private function _vote($relationship,$model,$vote){
         if($relationship->where('votable_id',$model->id)->exists()){
            $relationship->updateExistingPivot($model,['vote'=>$vote]);
        }
        else{
            $relationship->attach($model,['vote'=>$vote]);
        }
        $model->load('votes');
        // $downvotes = (int) $question->votes()->wherePivot('vote',-1)->sum('vote');
        $downVotes = (int) $model->downVotes()->sum('vote');
        //   $upvotes = (int) $question->votes()->wherePivot('vote',1)->sum('vote');
        $upVotes = (int) $model->upVotes()->sum('vote');

        $model->votes_count = $upVotes + $downVotes ;
        $model->save();
    }
}
