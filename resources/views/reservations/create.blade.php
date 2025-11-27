@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-lg mt-10 bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-6">Add Reservation for "{{ $book->title }}"</h1>

    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('reservations.store', $book->id) }}">
        @csrf

        <div class="flex justify-between items-center">
            <a href="{{ route('reservations.listUI', $book->id) }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">
                Cancel
            </a>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Add Reservation
            </button>
        </div>
    </form>
</div>
@endsection
