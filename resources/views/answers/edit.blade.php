@extends('layouts.app') @section('content')
<div class="container">
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h1>Editing answer for question : <strong>{{$question->title}}</strong></h1>
                    </div>
                    <hr />
                    <form action="{{route('questions.answers.update',[$question->id,$answer->id])}}" method="POST">
                        @csrf @method('PATCH')
                        <!-- Patch method I used because only one thing need to update , if theres are many thing need to update much better to use PUT instead of PATCH -->
                        <div class="form-group">
                            <textarea class="form-control {{ $errors->has('body') ? 'is-invalid':'' }}" name="body" rows="10">
                                {{ old('body',$answer->body) }}
                        </textarea> @if($errors->has('body'))
                            <div class="invalid-feedback">
                                <strong>{{$errors->first('body')}}</strong>
                            </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-lg btn-outline-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection