<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h2>
                        {{ $answersCount . " " . Str::plural('Answer',$answersCount) }}
                    </h2>
                </div>
                <hr /> @include('layouts.messages') @foreach($answers as $answer)
                <div class="media">
                    <div class="d-flex flex-column vote-controls">
                        <a title="This answer is useful" class="vote-up">
                            <i class="fas fa-caret-up fa-3x"></i>
                        </a>
                        <span class="votes-count">
                            25
                        </span>
                        <a title="This answer is not useful" class="vote-down off">
                            <i class="fas fa-caret-down fa-3x"></i>
                        </a>
                        <a title="Mark this answer as Best answer" class="vote-accepted mt-2 ">
                            <i class="fas fa-check fa-2x"></i>
                        </a>
                    </div>
                    <div class="media-body">
                        {!! $answer->body !!}
                        <div class="float-right mt-3">
                            <span class="text-muted" style="font-size:small">
                                Answered
                                {{$answer->created_date}}
                            </span>
                            <div class="media mt-2">
                                <a href="{{$answer->user->url}}" class="pr-2">
                                    <img width="30px" height="30px" style="border-radius: 50%;"
                                        src="{{Gravatar::src($answer->user->email)}}" alt="" />
                                </a>
                                <div class="media-body mt-1">
                                    <a href="{{$answer->user->url}}">
                                        {{$answer->user->name}}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr /> @endforeach
            </div>
        </div>
    </div>
</div>