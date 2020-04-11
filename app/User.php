<?php

namespace App;

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
}