@extends('layouts.master')

@section('content')
    <nav class="main">
        <ul>
            <li><a href="{{ route('home') }}">&lt; Back</a></li>
            <li><a href="{{ route('account-update-form') }}">Update</a></li>
        </ul>
    </nav>

    @if(!empty($books['hospital']))
    <nav class="main">
        <ul>
            <li><a href="{{ route('books-detail') }}">Data</a></li>
        </ul>
    </nav>
    @endif
    <table class="data-book">
        <tr>
            <td>Username</td>
            <td>::</td>
            <td>{{ $user->name }}</td>
        </tr>
        <tr>
            <td>ID Card</td>
            <td>::</td>
            <td>{{ $user->id_card }}</td>
        </tr>
        <tr>
            <td>Email</td>
            <td>::</td>
            <td>{{ $user->email }}</td>
        </tr>
    </table>
    <table class="data-book">
        <h2>Data of Vaccine</h2>
        <tr>
            <td>Vaccine 1</td>
            <td>::</td>
            @if(!empty($books['vaccineI']))
                <td>{{ $books->vaccineI }}</td>
            @else
                <td> - </td>
            @endif
        </tr>
        <tr>
            <td>Price 1</td>
            <td>::</td>
            @if(!empty($books['priceI']))
                <td>{{ $books->priceI }}</td>
            @else
                <td> - </td>
            @endif
        </tr>
        <tr>
            <td>Vaccine 2</td>
            <td>::</td>
            @if(!empty($books['vaccineII']))
                <td>{{ $books->vaccineII }}</td>
            @else
                <td> - </td>
            @endif
        </tr>
        <tr>
            <td>Price 2</td>
            <td>::</td>
            @if(!empty($books['priceII']))
                <td>{{ $books->priceII }}</td>
            @else
                <td> - </td>
            @endif
        </tr>
        <tr>
            <td>Total</td>
            <td>::</td>
            @if(!empty($books['total_price']))
                <td>{{ $books->total_price }}</td>
            @else
                <td> - </td>
            @endif
        </tr>
    </table>
@endsection
