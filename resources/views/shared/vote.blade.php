@if ($model instanceof App\Question) @php $name = 'question'; $firstURISegment = 'questions'; @endphp @elseif ($model
instanceof App\Answer) @php $name = 'answer'; $firstURISegment = 'answers'; @endphp @endif @php $formId = $name . "-" .
$model->id; $formAction
= "/{$firstURISegment}/{$model->id}/vote"; @endphp
<div class="d-flex flex-column vote-controls">
    <!-- up vote start -->
    <a title="This {{ $name }} is useful" class="vote-up {{ Auth::guest() ? 'off' : '' }}"
        onclick="event.preventDefault(); document.getElementById('up-vote-{{ $formId }}').submit();">
        <i class="fas fa-caret-up fa-3x"></i>
    </a>
    <form id="up-vote-{{ $formId }}" action="{{ $formAction }}" method="POST" style="display:none;">
        @csrf
        <input type="hidden" name="vote" value="1">
    </form>
    <!-- up vote ends -->
    <!-- votes count counter start -->
    <span class="votes-count">
        {{$model->votes_count}}
    </span>
    <!-- votes count counter end -->
    <!-- down vote button start -->
    <a title="This {{ $name }} is not useful" class="vote-down {{ Auth::guest() ? 'off' : '' }}"
        onclick="event.preventDefault(); document.getElementById('down-vote-{{ $formId }}').submit();">
        <i class="fas fa-caret-down fa-3x"></i>
    </a>
    <form id="down-vote-{{ $formId }}" action="{{ $formAction }}" method="POST" style="display:none;">
        @csrf
        <input type="hidden" name="vote" value="-1">
    </form>
    <!-- down vote button ends -->
    @if ($model instanceof App\Question)
    <favorite-component :question="{{ $model }}"></favorite-component>
    <!--@include ('shared.favorite', [ 'model' => $model ])  -->

    @elseif ($model instanceof App\Answer) @include ('shared.accept', [ 'model' => $model ]) @endif
</div>
