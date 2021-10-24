@extends('layouts.main')

@section('title',$title)

@section('content')
    <form class="search" action="{{ route('hospital-list') }}" method="get">
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

    <nav>
        <ul>
            @can('create', \App\Models\Hospital::class)
            <li>
                <a href="{{ route('hospital-create-form') }}">New Hospital</a>
            </li>
            @endcan
        </ul>
    </nav>

    <table class="list">
        <tr>
            <th>Code</th>
            <th>Name</th>
            <th>Status</th>
            <th>No. of Product</th>
        </tr>
        @foreach($hospitals as $hospital)
        <tr>
            <td>{{ $hospital->code }}</td>
            <td><a href="{{ route('hospital-detail', ['hospitalCode' => $hospital->code,])}}">{{ $hospital->name }}</a></td>
            <td>{{ $hospital->status }}</td>
            <td>{{ $hospital->vaccines_count }}</td>
        </tr>
        @endforeach
    </table>
    <div>{{ $hospitals->withQueryString()->links() }}</div>

@endsection
