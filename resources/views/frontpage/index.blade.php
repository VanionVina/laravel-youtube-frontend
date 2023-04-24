@extends('layouts/layout')
@section('content')

    @if($errors->any())
    <ul>
        @foreach($errors->all() as $error)
            <li style="color:red">{{$error}}</li>
        @endforeach
    </ul>
    @endif

    @if(session()->has('message'))
    <ul>
        <li style="color:red">{{session()->get('message')}}</li>
    </ul>
    @endif
    
    <h1 style="text-align: center">Known channels</h1>
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