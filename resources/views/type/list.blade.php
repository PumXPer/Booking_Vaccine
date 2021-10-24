@extends('layouts.main')

@section('title',$title)

@section('content')
<main>
    <form class="search" action="{{ route('type-list') }}" method="get">
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
            @can('create', \App\Models\Type::class)
            <li>
                <a href="{{ route('type-create-form') }}">New Type</a>
            </li>
            @endcan
        </ul>
    </nav>

    <table class="list">
        <tr>
            <th>Code</th>
            <th>Name</th>
            <th>No. of Vaccine</th>
        </tr>
        @foreach($types as $type)
        <tr>
            <td>{{ $type->code }}</td>
            <td><a href="{{ route('type-detail', ['typeCode' => $type->code,])}}">{{ $type->name }}</a></td>
            <td>{{ $type->vaccines_count }}</td>
        </tr>
        @endforeach
    </table>
</main>
@endsection
