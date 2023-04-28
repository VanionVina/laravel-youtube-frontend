@extends('layouts/layout')
@section('content')

<p>
    <a href="{{route('channel.updateAll')}}" style="color:aqua">Check for new videos</a>
</p>
@if ($videos->isNotEmpty())
    <p>
        <a href="{{route('video.markAllAsWatched')}}">Mark all videos as watched</a>
    </p>
@endif
@if(session()->has('videoMessage'))
    <p style="color:green">{{session()->get('videoMessage')}}</p>
@endif

<div class="video" style="display:flex;flex-wrap:wrap;">
@if ($videos->isEmpty())
    <h1>All videos watched</h1>
@endif
@foreach ($videos as $video)
        <div style="max-width:320px;margin:10px">
            <a href="{{route('video.show', $video->id)}}">
                <img src="{{url('storage/' . $video->image_name)}}" alt="Loading image..." style="margin-bottom: 5px;" width="320px" height="180px">
                <p>{{$video->title}}</p>
            </a>
            <div>
                <a href="{{route('channel.show', $video->channel->id)}}">{{$video->channel->name}}</a>
                {{$video->getDateDifference()}}
                <a href="https://www.youtube.com/watch?v={{$video->video_id}}" style="color:grey">link</a>
                <a href="{{route('video.markAsWatched', $video)}}" style="color:indianred;float:right">X</a>
            </div>
        </div>
@endforeach
</div>

<div>
    {{$videos->links()}}
</div>

@endsection
