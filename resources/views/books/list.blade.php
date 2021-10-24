@extends('layouts.main')

@section('title','Books Vaccine')

@section('content')
<form action="{{ route('books-page') }}" method="get">
    <table class="wrap">
                <tr>
                    <td>
                        <input type="text" name="term" class="searchTerm" id="term" placeholder="Search..." value="{{ $search['term'] }}">
                        <button type="submit" class="searchBox">
                            <span><i class="fas fa-search"></i></span>
                        </button>
                    </td>
                </tr>
        </table>
</form>

<table class="list">
        <tr>
            <th>Code</th>
            <th>Name</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        @foreach($hospitals as $hospital)
        <tr>
            <td>{{ $hospital->code }}</td>
            <td>{{ $hospital->name }}</td>
            <td>{{ $hospital->status }}</td>
            <td><a href = "{{ route('books-create-form', ['hospitalCode' => $hospital->code,])}}">
                <button type="button">select</button>
                </a>
            </td>
        </tr>
        @endforeach
</table>
</form>
<div>{{ $hospitals->withQueryString()->links() }}</div>
@endsection
