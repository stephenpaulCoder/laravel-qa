<div class="media post">
    <div class="d-felx flex-column counters">
        <div class="vote">
            <strong>{{ $question->votes_count  }}</strong> {{ Str::plural('vote',$question->votes_count) }}
        </div>
        <div class="status {{ $question->status }}">
            <strong>{{ $question->answers_count  }}</strong> {{ Str::plural('answer',$question->answers_count) }}
        </div>
        <div class="view">
            {{ $question->views . " " . Str::plural('view',$question->votes_count) }}
        </div>
    </div>
    <div class="media-body">
        <div class="d-flex align-items-center">
            <h3 class="mt-0">
                <a href="{{ $question->url}}">{{$question->title}}</a>
            </h3>
            <div class="ml-auto">
                @can ('update', $question)
                <a href="{{ route('questions.edit', $question->id) }}" class="btn btn-sm btn-outline-info">Edit</a> @endcan @can ('delete', $question)
                <form class="form-delete" method="post" action="{{ route('questions.destroy', $question->id) }}">
                    @method('DELETE') @csrf
                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">Delete</button>
                </form>
                @endcan
            </div>
        </div>
        <p class="lead">
            Asked by :
            <a href="{{ $question->user->url }}">{{$question->user->name}}</a>
            <small class="text-muted">{{$question->created_date}}</small>
        </p>
        <div class="excerpt">
            {{ $question->excerpt }}
        </div>
    </div>
</div>