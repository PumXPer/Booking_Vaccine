<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{asset('/css/style-main.css')}}">
    <link rel="stylesheet" href="{{asset('/css/style-list.css')}}">
    <link rel="stylesheet" href="{{asset('/css/style-search.css')}}">
    <link rel="stylesheet" href="{{asset('/css/style-detail.css')}}">
    <link rel="stylesheet" href="{{asset('/css/style-form.css')}}">
</head>
<body>
    <main class="main">
        <h1>Account</h1>

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

        <div>@yield('content')</div>
    </main>

</body>
</html>
