@extends('panel.layouts.app')
@section('content')
<div class="container mt-4">
    <h4>Users Who Messaged You</h4>
    <ul class="list-group">
        @foreach ($users as $user)
            <li class="list-group-item">
                <a href="{{ route('vendor.chat.with', $user->id) }}">
                    {{ $user->name }} ({{ $user->email }})
                </a>
            </li>
        @endforeach
    </ul>
</div>
@endsection
