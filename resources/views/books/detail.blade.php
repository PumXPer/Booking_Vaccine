@extends('layouts.main')

@section('title','Data Your Vaccine')

@section('content')
<table class="data-book">
    <a class="books-edit" href="{{ route('update-form',['hospitalCode' => $hospital->code]) }}" method="get">Edit</a>
    <tr>
        <td>Email</td>
        <td>::</td>
        <td>{{ $user->email }}</td>
    </tr>
    <tr>
        <td>Name</td>
        <td>::</td>
        <td>{{ $user->name }}</td>
    </tr>
    <tr>
        <td>Hospital</td>
        <td>::</td>
        <td>{{ $books->hospital }}</td>
    </tr>
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
