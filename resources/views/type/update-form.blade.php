@extends('layouts.main')

@section('title',$title)

@section('content')
<form class="create-form" action="{{ route('type-update',['typeCode' => $type->code]) }}" method="post">
    @csrf
    <table class="form">
        <tr>
            <td>Code</td>
            <td>::</td>
            <td><input type="text" name="code"  value="{{ $type->code }}" /></td>
        </tr>
        <tr>
            <td>Name</td>
            <td>::</td>
            <td><input type="text" name="name" value="{{ $type->name }}" /></td>
        </tr>
        <tr>
            <td>Description</td>
            <td>::</td>
            <td><textarea name="description">{{ $type->description }}</textarea></td>
        </tr>
    </table>
        <div class="create-bu"><button type="submit">Update</button></div>
</form>
@endsection
