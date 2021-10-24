@extends('layouts.main')

@section('title',$title)

@section('content')
    <form class="search" action="{{ route('vaccine-list') }}" method="get">
        <table class="wrap-vac">
            <tr>
                <td>
                    <input type="text" name="term" class="searchTerm" id="term" placeholder="Search..." value="{{ $search['term'] }}">
                    <input type="number" name="minPrice" placeholder="Min Price" value="{{ $search['minPrice'] }}" />
                    <input type="number" name="maxPrice" placeholder="Max Price" value="{{ $search['maxPrice'] }}" />
                    <button type="submit" class="searchBox">
                        <span><i class="fas fa-search"></i></span>
                    </button>
                </td>
            </tr>
        </table>
    </form>

    <nav>
        <ul>
            @can('create', \App\Models\Vaccine::class)
            <li>
                <a href="{{ route('vaccine-create-form') }}">New Vaccine</a>
            </li>
            @endcan
        </ul>
    </nav>

    <table class="list">
        <tr>
            <th>Code</th>
            <th>Name</th>
            <th>Category</th>
            <th>Price</th>
            <th>No. of Hospitals</th>
        </tr>
        @foreach($vaccines as $vaccine)
        <tr>
            <td>{{ $vaccine->code }}</td>
            <td><a href="{{ route('vaccine-detail', ['vaccineCode' => $vaccine->code,])}}">{{ $vaccine->name }}</a></td>
            <td>{{ $vaccine->type['name'] }}</td>
            <td>{{ $vaccine->price }}</td>
            <td>{{ $vaccine->hospitals_count }}</td>
        </tr>
        @endforeach
    </table>
    <div>{{ $vaccines->withQueryString()->links() }}</div>

@endsection
