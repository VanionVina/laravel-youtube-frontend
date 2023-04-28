@extends('layouts/layout')
@section('content')

@if (session()->has('channelMessage'))
    <p style="color:green">{{session()->get('channelMessage')}}</p>
@endif

<div style="display:flex;flex-wrap:wrap">
    @foreach ($channels as $channel)
        <div style="width:200px;margin:10px">
            <a href="{{route('channel.show', $channel->id)}}">
                <img src="{{ url('storage/' . $channel->icon_name)}}" alt="Icon is loading" style="margin-bottom: 5px;border-radius:50px">
                <p style="text-align: center">{{$channel->name}}</p>
            </a>
        </div>
    @endforeach
</div>

@endsection