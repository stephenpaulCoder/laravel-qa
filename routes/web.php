<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/','QuestionsController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//you can except show method using the code below then create your own route show
Route::resource('questions', 'QuestionsController')->except('show');

// Route::get('/questions/{question}/answers','AnswersController@store')->name('answers.store');
// You can also use this following method
Route::resource('questions.answers', 'AnswersController')->except(['create','index','show']);
Route::get('/questions/{slug}','QuestionsController@show')->name('questions.show');

//single action controller that hold only single action
Route::post('/answers/{answer}/accept','AcceptAnswerController')->name('answers.accept');

Route::post('/questions/{question}/favorites','FavoritesController@store')->name('questions.favorite');
Route::delete('/questions/{question}/favorites','FavoritesController@destroy')->name('questions.unfavorite');

Route::post('/questions/{question}/vote','VoteQuestionController');
Route::post('/answers/{answer}/vote','VoteAnswerController');
