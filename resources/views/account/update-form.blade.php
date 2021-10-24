@extends('layouts.master')

@section('content')
<h3>Update Your Account</h3>
    <nav class="main">
    <ul>
        <li><a href="{{ route('account-detail') }}">&lt; Back</a></li>
    </ul>
    </nav>

<form class="create-form" action="{{ route('account-update')}}" method="post">
    @csrf
    <table class="form">
        <tr>
            <td>Email</td>
            <td>::</td>
            <td><input type="text" name="email" value="{{ old('email',$user->email) }}" /></td>
        </tr>
        <tr>
            <td>ID Card</td>
            <td>::</td>
            <td><input type="text" name="id_card"  value="{{ old('name',$user->id_card) }}" /></td>
        </tr>
        <tr>
            <td>Name</td>
            <td>::</td>
            <td><input type="text" name="name"  value="{{ old('name',$user->name) }}" /></td>
        </tr>
    </table>
    <div class="create-bu"><button type="submit">Update</button></div>
</form>
@endsection

