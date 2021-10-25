@extends('layouts.main')

@section('title',$title)

@section('content')
<form class="create-form" action="{{ route('hospital-update',['hospitalCode' => $hospital->code]) }}" method="post">
    @csrf
    <table class="form">
        <tr>
            <td>Code</td>
            <td>::</td>
            <td><input type="text" name="code"  value="{{ $hospital->code }}" /></td>
        </tr>
        <tr>
            <td>Name</td>
            <td>::</td>
            <td><input type="text" name="name" value="{{ $hospital->name }}" /></td>
        </tr>
        <tr>
            <td>Status</td>
            <td>::</td>
            <td><input type="text" name="status" value="{{ $hospital->status }}"/></td>
        </tr>
        <tr>
            <td>Address</td>
            <td>::</td>
            <td><textarea name="address">{{ $hospital->address }}</textarea></td>
        </tr>
    </table>
        <div class="create-bu"><button type="submit">Update</button></div>
</form>
@endsection
