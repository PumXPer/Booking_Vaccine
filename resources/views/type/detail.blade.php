@extends('layouts.main')

@section('title',$title)

@section('content')
<main>
    <nav>
        <ul>
            <li><a href="{{session()->get('bookmark.type-detail', route('type-list'))}}">&lt; Back</a></li>
            @can('update', \App\Models\Type::class)
            <li><a href="{{ route('type-manage-vaccine', ['typeCode' => $type->code,]) }}">Manage Vaccine</a></li>
            @endcan
            @can('update', \App\Models\Type::class)
            <li><a href="{{ route('type-update-form', ['typeCode' => $type->code]) }}">Update</a></li>
            @endcan
            @can('delete', $type)
            <li><a href="{{ route('type-delete', ['typeCode' => $type->code,]) }}">Delete</a></li>
            @endcan
        </ul>
    </nav>

    <table class="data">
        <tr>
            <td><strong>Code</strong></td>
            <td>::</td>
            <td>{{ $type->code }}</td>
        </tr>
        <tr>
            <td><strong>Name</strong></td>
            <td>::</td>
            <td>{{ $type->name }}</td>
        </tr>
        <tr>
            <td><strong>Description</strong></td>
            <td>::</td>
            <td>{{ $type->description }}</td>
        </tr>
    </table>

    <div>
        <h2>Vaccine In Type</h2>
    </div>

    <table class="list">
            <tr>
                <th>Code</th>
                <th>Name</th>
                <th>Price</th>
            </tr>
            @foreach($vaccines as $vaccine)
            <tr>
                <td>{{ $vaccine->code }}</td>
                <td>{{ $vaccine->name }}</td>
                <td>{{ $vaccine->price }}</td>
            </tr>
            @endforeach
        </table>

</main>
@endsection
