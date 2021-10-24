@extends('layouts.main')

@section('title',$title)

@section('content')
<main>
    <nav>
        <ul>
        <li><a href="{{ route('vaccine-detail', ['vaccineCode' => $vaccine->code,]) }}">&lt; Back</a></li>
        </ul>
    </nav>

    <form action="{{ route('vaccine-manage-hospital', ['vaccineCode' => $vaccine->code,]) }}" method="get">
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
            <li><a href="{{ route('vaccine-add-hospital-form', ['vaccineCode' => $vaccine->code,]) }}">Add hospital</a></li>
        </ul>
    </nav>



    <table class="list">
        <tr>
            <th>Code</th>
            <th>Name</th>
            <th>Owner</th>
            <th></th>
        </tr>
        @foreach($hospitals as $hospital)
        <tr>
            <td><a href="{{ route('hospital-detail', ['hospitalCode' => $hospital->code,])}}"> {{ $hospital->code   }}</a></td>
            <td>{{ $hospital->name }}</td>
            <td>{{ $hospital->owner }}</td>
            <td>
                <a href="{{ route('vaccine-remove-hospital',['vaccineCode' => $vaccine->code,
                                                        'hospitalCode' => $hospital->code,]) }}">Remove</a>
            </td>
        </tr>
        @endforeach
    </table>
    <div>{{ $hospitals->withQueryString()->links() }}</div>

</main>

@endsection
