@extends('layouts.main')

@section('title',$title)

@section('content')
<form class="create-form" action="{{ route('user-create') }}" method="post">
    @csrf
    <table class="form">
        <tr>
            <td>Email</td>
            <td>::</td>
            <td><input type="email" name="email" value="{{ old('email') }}" required/></td>
        </tr>
        <tr>
            <td>ID Card</td>
            <td>::</td>
            <td><input type="text" name="id_card"  required/></td>
        </tr>
        <tr>
            <td>Name</td>
            <td>::</td>
            <td><input type="text" name="name" value="{{ old('name') }}" required/></td>
        </tr>
        <tr>
            <td>Password</td>
            <td>::</td>
            <td><input type="password" name="password" value="{{ old('password') }}" /></td>
        </tr>
        <tr>
            <td>Role</td>
            <td>::</td>
            <td>
                <select name="role">
                <option value="">-- Plase select --</option>
                @foreach($roles as $role)
                    <option value ="{{ $role }}" {{ ($role === old('role'))? ' selected' : '' }}>
                        [{{ $role }}]
                    </option>
                @endforeach

                </select>
            </td>
        </tr>
    </table>
        <div class="create-bu"><button type="submit">Create</button></div>
</form>
@endsection
