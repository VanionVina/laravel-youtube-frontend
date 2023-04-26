@extends('layouts/layout')
@section('content')

<div class="video" style="display:flex;flex-wrap:wrap;">
@foreach ($videos as $video)
    <a href="{{route('video.show', $video->video_id)}}">
        <div style="max-width:320px;margin:10px">
            <img src="{{url('storage/' . $video->image_name)}}" style="margin-bottom: 5px">
            <p>{{$video->title}}</p>
            <a href="{{route('channel.show', $video->channel->channel_id)}}">{{$video->channel->name}}</a>
        </div>
    </a>
@endforeach
</div>
    {{ $videos->links() }}
@endsection