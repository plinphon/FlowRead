@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-md mt-10">
    <h1 class="text-2xl font-bold mb-6">Register</h1>

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="mb-4">
            <label for="username" class="block mb-1">Username</label>
            <input type="text" name="username" id="username" value="{{ old('username') }}" class="w-full border p-2 rounded">
        </div>
        <div class="mb-4">
            <label for="email" class="block mb-1">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" class="w-full border p-2 rounded">
        </div>
        <div class="mb-4">
            <label for="password" class="block mb-1">Password</label>
            <input type="password" name="password" id="password" class="w-full border p-2 rounded">
        </div>
        <div class="mb-4">
            <label for="password_confirmation" class="block mb-1">Confirm Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="w-full border p-2 rounded">
        </div>
        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Register</button>
    </form>
</div>
@endsection
