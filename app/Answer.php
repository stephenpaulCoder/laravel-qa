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
                $answer->question->decrement('answers_count');
            });


    }

    public function getCreatedDateAttribute(){
        return $this->created_at->diffForHumans();
    }

}
