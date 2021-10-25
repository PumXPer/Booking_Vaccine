@extends('layouts.main')

@section('title',$title)

@section('content')
<main>
    <nav>
        <ul>
            <li><a href="{{session()->get('bookmark.user-detail', route('user-list'))}}">&lt; Back</a></li>
            <li><a href="{{ route('user-update-form', ['email' => $user->email,]) }}">Update</a></li>
            <li><a href="{{ route('user-delete', ['email' => $user->email,]) }}">Delete</a></li>
        </ul>
    </nav>

    <table class="data">
        <tr>
            <td><strong>Email</strong></td>
            <td>::</td>
            <td>{{ $user->email }}</td>
        </tr>
        <tr>
            <td><strong>ID Card</strong></td>
            <td>::</td>
            <td>{{ $user->id_card }}</td>
        </tr>
        <tr>
            <td><strong>Name</strong></td>
            <td>::</td>
            <td>{{ $user->name }}</td>
        </tr>
        <tr>
            <td><strong>Role</strong></td>
            <td>::</td>
            <td>{{ $user->role }}</td>
        </tr>
        <tr>
            <td><b>Hospital</b></td>
            <td>::</td>
            @if(!empty($books['hospital']))
            <td>{{ $books->hospital }}</td>
            @else
                <td> - </td>
            @endif
        </tr>
        <tr>
            <td><b>Vaccine 1</b></td>
            <td>::</td>
            @if(!empty($books['vaccineI']))
                <td>{{ $books->vaccineI }}</td>
            @else
                <td> - </td>
            @endif
        </tr>
        <tr>
            <td><b>Vaccine 2</b></td>
            <td>::</td>
            @if(!empty($books['vaccineII']))
                <td>{{ $books->vaccineII }}</td>
            @else
                <td> - </td>
            @endif
        </tr>
    </table>
</main>
@endsection
