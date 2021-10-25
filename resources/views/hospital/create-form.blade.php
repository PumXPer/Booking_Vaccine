@extends('layouts.main')

@section('title',$title)

@section('content')
<form class="create-form" action="{{ route('hospital-create') }}" method="post">
    @csrf
    <table class="form">
        <tr>
            <td>Code</td>
            <td>::</td>
            <td><input type="text" name="code" /></td>
        </tr>
        <tr>
            <td>Name</td>
            <td>::</td>
            <td><input type="text" name="name" /></td>
        </tr>
        <tr>
            <td>Status</td>
            <td>::</td>
            <td><input type="text" name="status" /></td>
        </tr>
        <tr>
            <td>Address</td>
            <td>::</td>
            <td><textarea name="address"></textarea></td>
        </tr>
    </table>
        <div class="create-bu"><button type="submit">Create</button></div>
</form>
@endsection
