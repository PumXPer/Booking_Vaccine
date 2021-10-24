@extends('layouts.main')

@section('title',$title)

@section('content')
<form class="create-form" action="{{ route('vaccine-create') }}" method="post">
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
            <td>Type</td>
            <td>::</td>
            <td>
                <select name="type_id" required>
                <option value="">-- Plase select type --</option>
                @foreach($types as $type)
                    <option value="{{ $type->id }}">[{{ $type->code }}]{{ $type->name }}</option>
                @endforeach
                </select>
            </td>
        </tr>
        <tr>
            <td>Price</td>
            <td>::</td>
            <td><input type="number" step="any" name="price" /></td>
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
