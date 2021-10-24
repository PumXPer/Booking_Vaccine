@extends('layouts.main')

@section('title',$title)

@section('content')
<form action="{{ route('hospital-create') }}" method="post">
    @csrf
    <table>
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
        <tr>
            <td><button type="submit">Create</button></td>
        </tr>
    </table>
</form>
@endsection
