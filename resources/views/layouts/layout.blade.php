<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/pico.css')}}">
</head>
<body>
    <nav style="margin: 0px 20px 0px 20px">
        <ul>
            <a href="{{route('index')}}"><li style="color:aquamarine ">MyTube</li></a>
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
        <ul></ul>
    </nav>
    <main class="container-fluid" style="padding-top: 0px">
        @yield('content')
    </main>
</body>
</html>