@extends('layouts/layout')
@section('content')

<div style="width:90%;margin-right:50px;margin-left:50px">

    <div style=" display: flex; align-items: center; justify-content: center;">
            <iframe width="100%" height="720px" style="max-width:1300px" src="{{$invidious_instance}}/embed/{{$video->video_id}}" frameborder="0" allowfullscreen></iframe>
    </div>

    <hr>
    <div style="margin-top: 15px">
        <h2>{{$video->title}}</h2>
    </div>

    <div style="display:grid;grid-template-columns: 270px 1fr">
        <div>
            <a href="{{ route('channel.show', $video->channel->id) }}">
            <div style="block;margin-bottom:20px">
                <div style="margin-bottom:10px;text-align:center"><span style="font-size:20px">{{$video->channel->name}}</span></div>
                <div>
                    <img src="{{$video->channel->icon_url}}" style="width:250px;border-radius:20px;">
                </div>
            </div>
            </a>
        </div>
        <div>
            <div style="display:grid;grid-template-columns: 270px 270px">
                <div>
                    <a href="{{$invidious_instance}}/watch?v={{$video->video_id}}" target="_blank"><p>Watch on invidious</p></a>
                </div>
                <div>
                    <a href="https://www.youtube.com/watch?v={{$video->video_id}}" target="_blank"><p>Youtube link</p></a>
                </div>
            </div>
            <p style="color:gray">Published: {{$video->published}}</p>
            <div style="white-space: pre-wrap">
                <p>{{$video->description}}</p>
            </div>
        </div>
    </div>
</div>

@endsection
