@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-md mt-10">
    <h1 class="text-2xl font-bold mb-6">Update Username</h1>

    <form method="POST" action="{{ route('update.username') }}">
        @csrf
        <div class="mb-4">
            <label for="username" class="block mb-1">New Username</label>
            <input type="text" name="username" id="username" value="{{ old('username', auth()->user()->username) }}" class="w-full border p-2 rounded">
        </div>
        <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded">Update</button>
    </form>
</div>
@endsection
