@extends('layouts/layout')
@section('content')

<div style="display:flex;flex-wrap:wrap">
    @foreach ($channels as $channel)
        <a href="{{route('channel.show', $channel->channel_id)}}">
            <div style="width:200px;margin:10px">
                <img src="{{$channel->icon_url}}" style="margin-bottom: 5px;border-radius:50px">
                <p style="text-align: center">{{$channel->name}}</p>
            </div>
        </a>
    @endforeach
</div>

@endsection