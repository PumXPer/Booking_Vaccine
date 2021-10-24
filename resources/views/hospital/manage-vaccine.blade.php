@extends('layouts.main')

@section('title',$title)

@section('content')
<main>
    <nav>
        <ul>
        <li><a href="{{ route('hospital-detail', ['hospitalCode' => $hospital->code,]) }}">&lt; Back</a></li>
        </ul>
    </nav>

    <form action="{{ route('hospital-manage-vaccine', ['hospitalCode' => $hospital->code,]) }}" method="get">
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
            <li><a href="{{ route('hospital-add-vaccine-form', ['hospitalCode' => $hospital->code,]) }}">Add vaccine</a></li>
        </ul>
    </nav>

    <table class="list">
        <tr>
            <th>Code</th>
            <th>Name</th>
            <th>Price</th>
            <th></th>
        </tr>
        @foreach($vaccines as $vaccine)
        <tr>
            <td><a href="{{ route('vaccine-detail', ['vaccineCode' => $vaccine->code,])}}"> {{ $vaccine->code }}</a></td>
            <td>{{ $vaccine->name }}</td>
            <td>{{ $vaccine->price }}</td>
            <td>
                <a href="{{ route('hospital-remove-vaccine',['hospitalCode' => $hospital->code,
                                                        'vaccineCode' => $vaccine->code,]) }}">Remove</a>
            </td>
        </tr>
        @endforeach
    </table>
    <div>{{ $vaccines->withQueryString()->links() }}</div>


</main>

@endsection
