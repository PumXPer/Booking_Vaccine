@extends('layouts.main')

@section('title','Login')

@section('content')
    <form class="login" action="{{ route('authenticate') }}" method="post">
        <div class="wrap-login">
        @csrf
            <label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" required />
                    @error('email')
                        <span role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
            </label><br />
            <label>
                <input type="password" name="password" placeholder="Password" required />
                    @error('password')
                        <span role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
            </label><br />

            @error('credentials')
                    <span role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
            @enderror <br />
            <button class="login-sub" type="submit">Login</button>

                </div>
            <nav class="action-a">
                <ul>
                    <li><a href="{{ route('register-form') }}">Create New Account</a></li>
                </ul>
            </nav>

    </form>
@endsection

