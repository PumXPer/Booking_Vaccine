@extends('layouts.main')

@section('title','Update Your Vaccine')

@section('content')

<form action="{{ route('books-update',['hospitalCode' => $hospital->code]) }}" method="post">
<table class="book">
    @csrf
    <tr>
        <td>
            <label>
                <b>Vaccine I</b>::
                    <select name="vaccineI" required>
                        <option value="">-- Please select --</option>
                        @foreach($vaccines as $vaccine)
                            <option value="{{ $vaccine->name }}" {{ ($vaccine->name ===  old('vaccineI', $books->vaccineI))? ' selected' : '' }}>
                                {{ $vaccine->name }}</option>
                        @endforeach
                    </select>เข็ม
            </label>
        </td>
    </tr>
    <tr>
        <td>
            <label>
                <b>Vaccine II</b>::
                    <select name="vaccineII" >
                        <option value="-">-- Please select --</option>
                        @foreach($vaccines as $vaccine)
                            <option value="{{ $vaccine->name }}" {{ ($vaccine->name ===  old('vaccineII', $books->vaccineII))? ' selected' : '' }}>
                                {{ $vaccine->name }}</option>
                        @endforeach
                    </select>เข็ม
            </label>
        </td>
    </tr>
    <tr>
    <div class="books-bu">
        <td>
            <button type="submit">submit</button>
            <a href="{{  route('books-create-form', ['hospitalCode' => $hospital->code,]) }}">
                <button type="button">Clear</button>
            </a>
        </td>
    </div>
    </tr>
</table>
</form>
@endsection
