@extends('layouts/layout')
@section('content')

<a href="{{route('channel.updateAll')}}"><p style="color:aqua">Check for new videos</p></a>
<a href="{{route('video.markAllAsWatched')}}"><p>Mark all videos as watched</p></a>
@if(session()->has('videoMessage'))
    <p style="color:green">{{session()->get('videoMessage')}}</p>
@endif

<div class="video" style="display:flex;flex-wrap:wrap;">
@if ($videos->isEmpty())
    <h1>All videos watched</h1>
@endif
@foreach ($videos as $video)
    <a href="{{route('video.show', $video->video_id)}}">
        <div style="max-width:320px;margin:10px">
            <img src="{{url('storage/' . $video->image_name)}}" alt="Loading image..." style="margin-bottom: 5px;" width="320px" height="180px">
            <p>{{$video->title}}</p>
            <a href="{{route('channel.show', $video->channel->channel_id)}}">{{$video->channel->name}}</a>
            {{$video->getDateDifference()}}
            <a href="https://www.youtube.com/watch?v={{$video->video_id}}" style="color:grey">link</a>
        </div>
    </a>
@endforeach
</div>

<div>
    {{$videos->links()}}
</div>

@endsection