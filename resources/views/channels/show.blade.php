@extends('layouts/layout')
@section('content')

<div style="display:grid;grid-template-columns: 270px 1fr;height:220px">
    <div>
        <img src="{{$channel->icon_url}}" style="margin-bottom: 5px;border-radius:50px;width:200px">
    </div>
    <div>
        <h1 ><strong>{{$channel->name}}</strong></h1>
        <a href="{{route('channel.updateVideos', $channel->channel_id)}}"><p style="color:aqua">Update channel videos</p></a>
        @if (session()->has('channelMessage'))
            <p style="color:green">{{session()->get('channelMessage')}}</p>
        @endif
    </div>
</div>
<hr>
<div class="video" style="display:flex;flex-wrap:wrap;">
@foreach ($videos as $video)
    <a href="{{route('video.show', $video->video_id)}}">
        <div style="max-width:320px;margin:10px">
            <img src="{{url('storage/' . $video->image_name)}}" alt="Loading image..." style="margin-bottom: 5px;width:320px;">
            <p>{{$video->title}}</p>
        </div>
    </a>
@endforeach
</div>

@endsection