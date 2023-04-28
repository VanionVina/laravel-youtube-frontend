@extends('layouts/layout')
@section('content')

<div class="container" style="margin-top:20px">
    <p>How to get csv file from youtube: <a href="https://docs.invidious.io/export-youtube-subscriptions/" target="_blank">link</a></p>
    <hr>
    <form method="POST" action="{{route('channel.loadFromFilePost')}}" enctype="multipart/form-data">
    @csrf
        <label for="file">CSV:
            <input type="file" name="file">
        </label>
        <br>
        <button type="submit" style="width:200px">Import</button>
    </form>
</div>

@endsection
