<span class="text-muted" style="font-size:small">
    {{ $label . "" .$model->created_date}}
</span>
<div class="media mt-2">
    <a href="{{$model->user->url}}" class="pr-2">
        <img width="30px" height="30px" style="border-radius: 50%;" src="{{Gravatar::src($model->user->email)}}"
            alt="" />
    </a>
    <div class="media-body mt-1">
        <a href="{{$model->user->url}}">
            {{$model->user->name}}
        </a>
    </div>
</div>