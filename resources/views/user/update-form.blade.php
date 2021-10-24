@extends('layouts.main')

@section('title',$title)

@section('content')
<form  class="create-form" action="{{ route('user-update',['email' => $user->email]) }}" method="post">
    @csrf
    <table class="form">
        <tr>
            <td>Email</td>
            <td>::</td>
            <td><input type="text" name="email"  value="{{ old('email', $user->email) }}" required/></td>
        </tr>
        <tr>
            <td>Name</td>
            <td>::</td>
            <td><input type="text" name="name" value="{{ old('name', $user->name) }}" required/></td>
        </tr>
        <tr>
            <td>Password</td>
            <td>::</td>
            <td>
                <input type="password" name="password" placeholder="Please leave blank." /></td>
        </tr>
        <tr>
            <td>Role</td>
            <td>::</td>
            <td>
                <select name="role">
                <option value="">-- Plase select --</option>
                @foreach($roles as $role)
                    <option value ="{{ $role }}" {{ ($role === old('role', $user->role))? ' selected' : '' }}>
                        [{{ $role }}] {{ $role }}
                    </option>
                @endforeach
                </select>
            </td>
        </tr>
    </table>
        <div class="create-bu"><button type="submit">Update</button></div>
</form>
@endsection
