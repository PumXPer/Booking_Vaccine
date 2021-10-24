@extends('layouts.main')

@section('title',$title)

@section('content')
<main>
    <form action="{{ route('user-list') }}" method="get">
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
</main>

    <nav>
        <ul>
            <li>
                <a href="{{ route('user-create-form') }}">New User</a>
            </li>
        </ul>
    </nav>

    <table class="list">
        <tr>
            <th>Email</th>
            <th>Name</th>
            <th>Role</th>
        </tr>
        @foreach($users as $user)
        <tr>
            <td><a href="{{ route('user-detail', ['email' => $user->email,])}}">{{ $user->email }}</a></td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->role }}</td>
        </tr>
        @endforeach
    </table>
    <div>{{ $users->withQueryString()->links() }}</div>
@endsection
