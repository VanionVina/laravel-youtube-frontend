@extends('layouts/layout')
@section('content')

<div class="video" style="display:flex;flex-wrap:wrap;">
@foreach ($videos as $video)
        <div style="max-width:320px;margin:10px">
            <a href="{{route('video.show', $video->id)}}">
                <img src="{{url('storage/' . $video->image_name)}}" alt="Loading image..." style="margin-bottom: 5px;" width="320px" height="180px">
                <p>{{$video->title}}</p>
            </a>
            <a href="{{route('channel.show', $video->channel)}}">{{$video->channel->name}}</a>
            {{$video->getDateDifference()}} 
            <a href="https://www.youtube.com/watch?v={{$video->video_id}}" style="color:grey">link</a>
        </div>
@endforeach
</div>

<div>
    {{ $videos->links() }}
</div>
@endsection