<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{asset('/css/style-main.css')}}">
    <link rel="stylesheet" href="{{asset('/css/style-list.css')}}">
    <link rel="stylesheet" href="{{asset('/css/style-search.css')}}">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{asset('/css/style-detail.css')}}">
    <link rel="stylesheet" href="{{asset('/css/style-form.css')}}">
</head>

<body>
    <header>
        <nav class="main">
            <ul>
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('vaccine-list') }}">Vaccine</a></li>
                <li><a href="{{ route('type-list') }}">Type Vaccines</a></li>
                <li><a href="{{ route('hospital-list') }}">Hospital</a></li>
                <li><a href="{{ route('books-page') }}">Books Vaccine</a></li>
                @can('read', \App\Models\User::class)
                <li><a href="{{ route('user-list') }}">User</a></li>
                @endcan
                @auth
                    <li><a href="{{ route('account-detail') }}">{{ \Auth::user()->name }}</a></li>
                    <li><a href="{{ route('logout') }}">Logout</a></li>
                @else
                    <li><a href="{{ route('login') }}">Login</a></li>
                @endauth
            </ul>
        </nav>
    </header>
    <main class="main">
        <h1>@yield('title')</h1>

        @error('error')
            <div class="status-error">
                <span>{{ $message }}</span>
            </div>
        @enderror

        @if(session()->has('status'))
            <div class="status-pass">
                <span>{{ session()->get('status') }}</span>
            </div>
        @endif

        <div>
            @yield('content')
        </div>
    </main>


        <footer>&#169;(ProjecT)Books a Vaccine COVID19[2021]</footer>

</body>
</html>
