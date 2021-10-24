@extends('layouts.main')

@section('title','Register')

@section('content')
<form class="register-form" method="POST" action="{{ route('register') }}">
    @csrf
    <input type="hidden" name="role" value="USER" />
    <table class="register">
        <tr align="left">
            <td>ID Card</td>
        </tr>
        <tr>
            <td>
                <input type="text"name="id_card" value="{{ old('id_card') }}" required><br />
                        @error('id_card')
                            <span role="alert">
                                    <strong class="error">{{ $message }}</strong>
                            </span>
                        @enderror
            </td>
        </tr>
        <tr align="left">
            <td>Name</td>
        </tr>
        <tr>
                <td>
                    <input type="text"name="name" value="{{ old('name') }}" required><br />
                        @error('name')
                            <span role="alert">
                                    <strong class="error">{{ $message }}</strong>
                            </span>
                        @enderror
                </td>
        </tr>
        <tr align="left">
            <td>Email</td>
        </tr>
        <tr>
            <td>
                <input type="email"name="email" value="{{ old('email') }}" required><br />
                    @error('email')
                        <span role="alert">
                            <strong class="error">{{ $message }}</strong>
                        </span>
                    @enderror
            </td>
        </tr>
    </table>
    <table class="password">
        <tr align="left">
            <td>Password</td>
            <td>Password Confirm</td>
        </tr>
        <tr>
            <td>
                <input type="password"  name="password" required>
            </td>
            <td>
                <input type="password"  name="password_confirmation" required>
            </td>
        </tr>
        <tr>
            <td>
                <span class="font-password">**Password want 8 character</span>
            </td>
        </tr>
    </table>
    <table class="form">
        <tr>
            <td>
            @error('password')
                <span role="alert">
                    <strong class="error">{{ $message }}</strong>
                </span>
            @enderror
            </td>
        </tr>
    </table>
        <button type="submit">Register</button>
</form>
@endsection
