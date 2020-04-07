<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    //
    protected $fillable = ['title','body'];

    // a question belongs to user
    public function user(){
        return $this->belongsTo(User::class);
    }


}