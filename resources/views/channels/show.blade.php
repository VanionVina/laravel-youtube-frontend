@extends('layouts/layout')
@section('content')

<div style="display:grid;grid-template-columns: 270px 1fr;height:220px">
    <div>
        <img src="{{ url('storage/' . $channel->icon_name)}}" alt="Icon is loading" style="margin-bottom: 5px;border-radius:50px" width="200px">
    </div>
    <div>
        <h1 style="margin-bottom:20px"><strong>{{$channel->name}}</strong></h1>
        <p><a href="{{$invidious_link}}" target="_blank">Invidious link</a></p>
        <p><a href="{{route('channel.updateVideos', $channel->channel_id)}}" style="color:aqua">
            Update channel videos
        </p></a>
        @if (session()->has('channelMessage'))
            <p style="color:green">{{session()->get('channelMessage')}}</p>
        @endif
    </div>
</div>
<hr>
<div class="video" style="display:flex;flex-wrap:wrap;">
@foreach ($videos as $video)
    <div style="max-width:320px;margin:10px">
        <a href="{{route('video.show', $video->video_id)}}">
            <img src="{{url('storage/' . $video->image_name)}}" alt="Loading image..." style="margin-bottom: 5px;" width="320px" height="180px">
            <p>{{$video->title}}</p>
        </a>
        {{$video->getDateDifference()}}
        <a href="https://www.youtube.com/watch?v={{$video->video_id}}" style="color:grey">link</a>
    </div>
@endforeach
</div>

@endsection