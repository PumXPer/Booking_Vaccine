@extends('layouts.main')

@section('title',$title)

@section('content')
<form class="create-form" action="{{ route('type-create') }}" method="post">
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
            <td>Description</td>
            <td>::</td>
            <td><textarea name="description"></textarea></td>
        </tr>
    </table>
        <div class="create-bu"><button type="submit">Create</button></div>

</form>
@endsection
