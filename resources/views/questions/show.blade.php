@extends('layouts.app') @section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <div class="d-flex align-items-center">
                            <h1>{{$question->title}}</h1>
                            <div class="ml-auto">
                                <a href="{{ route('questions.index') }}" class="btn btn-outline-secondary">Back to All
                                    Questions</a>
                            </div>
                        </div>
                    </div>
                    <hr />
                    <div class="media">
                        @include('shared.vote',[ 'model'=>$question ])
                        <div class="media-body">
                            {!! $question->body !!}
                            <div class="row">
                                <div class="col-4"></div>
                                <div class="col-4"></div>
                                <div class="col-4">
                                    <!-- @include('shared.author', [ 'model'=>$question, 'label'=>'asked' ]) -->
                                    <author-component :model="{{$question}}" label="Asked"> </author-component>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('answers.index',[ 'answers'=>$question->answers, 'answersCount'=>$question->answers_count, ]) @include('answers.create')
</div>
@endsection