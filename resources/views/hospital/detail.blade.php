@extends('layouts.main')

@section('title',$title)

@section('content')
<main>
    <nav>
        <ul>
            <li><a href="{{session()->get('bookmark.hospital-detail', route('hospital-list'))}}">&lt; Back</a></li>
            @can('update', \App\Models\Vaccine::class)
            <li><a href="{{ route('hospital-manage-vaccine', ['hospitalCode' => $hospital->code,]) }}">Manage Vaccine</a></li>
            @endcan
            @can('update', \App\Models\Vaccine::class)
            <li><a href="{{ route('hospital-update-form', ['hospitalCode' => $hospital->code]) }}">Update</a></li>
            @endcan
            @can('delete', \App\Models\Vaccine::class)
            <li><a href="{{ route('hospital-delete', ['hospitalCode' => $hospital->code,]) }}">Delete</a></li>
            @endcan
        </ul>
    </nav>
    <table class="data">
        <tr>
            <td><strong>Code</strong></td>
            <td>::</td>
            <td>{{ $hospital->code }}</td>
        </tr>
        <tr>
            <td><strong>Name</strong></td>
            <td>::</td>
            <td>{{ $hospital->name }}</td>
        </tr>
        <tr>
            <td><strong>Address</strong></td>
            <td>::</td>
            <td>{{ $hospital->address }}</td>
        </tr>
    </table>

    <div>
        <h2>Vaccine In Stock</h2>
    </div>

    <table class="list">
        <tr>
            <th>Code</th>
            <th>Name</th>
            <th>Category</th>
            <th>Price</th>
        </tr>
        @foreach($vaccines as $vaccine)
        <tr>
            <td>{{ $vaccine->code }}</td>
            <td>{{ $vaccine->name }}</td>
            <td>{{ $vaccine->type['name'] }}</td>
            <td>{{ $vaccine->price }}</td>
        </tr>
        @endforeach
    </table>
</main>
@endsection
