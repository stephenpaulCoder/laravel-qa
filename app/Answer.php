<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Question;
use App\User;

class Answer extends Model
{
    //

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
}