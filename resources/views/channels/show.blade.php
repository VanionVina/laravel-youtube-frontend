@extends('layouts/layout')
@section('content')
<style>
    .video {
    box-shadow: 0 1px 2px rgba(0,0,0,0.15);
    }

    /* Pre-render the bigger shadow, but hide it */
    .video::after {
    box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    opacity: 0;
    transition: opacity 0.3s ease-in-out;
    }

    /* Transition to showing the bigger shadow on hover */
    .video:hover::after {
    opacity: 1;
    }
</style>

<div style="display:grid;grid-template-columns: 270px 1fr;height:220px">
    <div>
        <img src="{{$channel->icon_url}}" style="margin-bottom: 5px;border-radius:50px;width:200px">
    </div>
    <div>
        <h1 ><strong>{{$channel->name}}</strong></h1>
    </div>
</div>
<hr>
<div class="video" style="display:flex;flex-wrap:wrap;">
@foreach ($videos as $video)
    <a href="{{route('video.show', $video->video_id)}}">
        <div style="max-width:320px;margin:10px">
            <img src="{{$video->image_url}}" style="margin-bottom: 5px">
            <p>{{$video->title}}</p>
        </div>
    </a>
@endforeach
</div>
@endsection