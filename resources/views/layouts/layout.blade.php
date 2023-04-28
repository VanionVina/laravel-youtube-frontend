<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MyTube</title>
    <link rel="stylesheet" href="{{ asset('css/pico.css')}}">
</head>
<body>
    <nav style="margin: 0px 20px 0px 20px">
        <ul>
            <a href="{{route('index')}}"><li style="color:aquamarine;margin-right:15px">MyTube</li></a>
            <a href="{{route('channel.index')}}"><li style="color:aqua;margin-right:15px">Channels</li></a>
            <a href="{{route('video.newVideos')}}"><li>Unwached videos</li></a>
        </ul>
        <ul>
            <li>
                <form method="POST" action="{{route('channel.search')}}">
                    @csrf
                    <label for="search">Channel id:
                    <input type="text" name="search">
                    </label>
                </form>
            </li>
        </ul>
        <ul>
            <li><a href="{{route('channel.loadFromFile')}}">Import YouTube subscription</a></li>
        </ul>
    </nav>
    <main class="container-fluid" style="padding-top: 0px">
        @if($errors->any())
        <ul>
            @foreach($errors->all() as $error)
                <li style="color:red">{{$error}}</li>
            @endforeach
        </ul>
        @endif

        @if(session()->has('errorMessage'))
        <ul>
            <li style="color:red">{{session()->get('errorMessage')}}</li>
        </ul>
        @endif

        @yield('content')

    </main>
</body>
</html>
