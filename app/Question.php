<?php

namespace App;
use App\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Yansongda\LaravelParsedown\Facades\Parsedown;

class Question extends Model
{

    protected $appends = ['created_date'];
    //
    //use VotableTrait;
    use VotableTrait;
    protected $fillable = ['title','body'];

    // a question belongs to user
    public function user(){
        return $this->belongsTo(User::class);
    }


    public function setTitleAttribute($value){

        $this->attributes['title']=$value;
        $this->attributes['slug'] =  Str::slug($value);
    }


    public function getUrlAttribute(){
        return route('questions.show',$this->slug);
    }

    public function getCreatedDateAttribute(){
        return $this->created_at->diffForHumans();
    }

    public function getStatusAttribute(){
        if($this->answers_count > 0){
            if($this->best_answer_id){
                return "answered-accepted";
            }
            return "answered";
        }
        return "unanswered";
    }

    //prevent XSS attack
    /**
     * example paste in registration for or what kind of form
     * <p>Stephen Paul simple XSS </p><script>alert('Success XSS')</script>
     */

    //use Clean library using clean($this->bodyHtml());
    public function getBodyHtmlAttribute(){
        return clean($this->bodyHtml());
    }
    /**
     * another way to use Clean library
     *
     * public function setBodyAttribute($value){
     * $this->attributes['body]=clean($value);
     * }
     */

    //prevent XSS attack
    public function getExcerptAttribute(){
    //   return  Str::limit(strip_tags($this->bodyHtml()),250);
    return $this->excerpt(250);
    }
    //prevent XSS attack
    public function excerpt($length){
     return  Str::limit(strip_tags($this->bodyHtml()),$length);
    }
    //prevent XSS attack
    private function bodyHtml(){
      return Parsedown::instance()->text($this->body);
    }
    //link for parsedown  https://github.com/yansongda/laravel-parsedown external library

    //relationship model to answer model
    public function answers(){
        return $this->hasMany(Answer::class)->orderBy('votes_count','DESC');
    //question->answers()->count()
    }

    public function acceptBestAnswer(Answer $answer){
        $this->best_answer_id = $answer->id;
        $this->save();
    }


    public function favorites()
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps(); //, 'question_id', 'user_id');
    }

    public function isFavorited()
    {
        return $this->favorites()->where('user_id', auth()->id())->count() > 0;
    }

    public function getIsFavoritedAttribute()
    {
        return $this->isFavorited();
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }


    //first relationship method in votable and second arguemnet for the pivot table name
    //refactor the code and paste in VotableTrait.php
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


}