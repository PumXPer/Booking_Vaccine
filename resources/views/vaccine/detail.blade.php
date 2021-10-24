@extends('layouts.main')

@section('title',$title)

@section('content')
<main>
    <nav>
        <ul>
            <li><a href="{{session()->get('bookmark.vaccine-detail', route('vaccine-list'))}}">&lt; Back</a></li>
            @can('update', \App\Models\Vaccine::class)
            <li><a href="{{ route('vaccine-manage-hospital', ['vaccineCode' => $vaccine->code,]) }}">Manage Hospital</a></li>
            @endcan
            @can('update', \App\Models\Vaccine::class)
            <li><a href="{{ route('vaccine-update-form', ['vaccineCode' => $vaccine->code]) }}">Update</a></li>
            @endcan
            @can('delete', \App\Models\Vaccine::class)
            <li><a href="{{ route('vaccine-delete', ['vaccineCode' => $vaccine->code,]) }}">Delete</a></li>
            @endcan
        </ul>
    </nav>

    <table  class="data">
        <tr>
            <td><strong>Code</strong></td>
            <td>::</td>
            <td>{{ $vaccine->code }}</td>
        </tr>
        <tr>
            <td><strong>Name</strong></td>
            <td>::</td>
            <td>{{ $vaccine->name }}</td>
        </tr>
        <tr>
            <td><strong>Type</strong></td>
            <td>::</td>
            <td>[{{ $vaccine->type['code'] }}] {{ $vaccine->type['name'] }}</td>
        </tr>
        <tr>
            <td><strong>Price</strong></td>
            <td>::</td>
            <td>{{ number_format((double)$vaccine->price, 2) }}</td>
        </tr>
    </table>
    <pre>{{ $vaccine->description }}</pre>


    <div>
        <h2>Vaccine With Hospital</h2>
    </div>
    <table class="list">
        <tr>
            <th>Code</th>
            <th>Name</th>
            <th>Status</th>
        </tr>
        @foreach($hospitals as $hospital)
        <tr>
            <td>{{ $hospital->code }}</td>
            <td>{{ $hospital->name }}</td>
            <td>{{ $hospital->status }}</td>
        </tr>
        @endforeach
    </table>
</main>
@endsection
