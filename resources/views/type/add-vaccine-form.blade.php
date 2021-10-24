@extends('layouts.main')

@section('title',$title)

@section('content')
<main>

    <nav>
        <ul>
            <li><a href="{{ route('type-manage-vaccine', ['typeCode' => $type->code,]) }}">&lt; Back</a></li>
        </ul>
    </nav>

    <form action="{{ route('type-add-vaccine-form', ['typeCode' => $type->code,]) }}" method="get">
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

    <form action="{{ route('type-add-vaccine', ['typeCode' => $type->code,]) }}" method="post">
        @csrf
        <table class="list">
            <tr>
                <th>Code</th>
                <th>Name</th>
                <th>Type</th>
                <th>Price</th>
                <th></th>
            </tr>
            @foreach($vaccines as $vaccine)
            <tr>
                <td><a href="{{ route('vaccine-detail', ['vaccineCode' => $vaccine->code,])}}"> {{ $vaccine->code }}</a></td>
                <td>{{ $vaccine->name }}</td>
                <td>{{ $vaccine->type['name'] }}</td>
                <td>{{ $vaccine->price }}</td>
                <td>
                    <button type="submit" name="vaccine" value="{{ $vaccine->code }}">Add</button>
                </td>
            </tr>
            @endforeach
        </table>
    </form>
    <div>{{ $vaccines->withQueryString()->links() }}</div>

</main>

@endsection
