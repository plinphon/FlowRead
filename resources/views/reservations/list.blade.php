@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-10">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Reservations for "{{ $book->title }}"</h1>

        <a href="{{ route('reservations.createUI', $book->id) }}"
           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
           + Add Reservation
        </a>
    </div>

    <div class="bg-white shadow rounded-lg p-6">
        @if($reservations->isEmpty())
            <p class="text-gray-500">No reservations yet.</p>
        @else
        <table class="min-w-full">
            <thead>
                <tr class="border-b">
                    <th class="py-3 text-left">ID</th>
                    <th class="py-3 text-left">Position</th>
                    <th class="py-3 text-left">Status</th>
                    <th class="py-3 text-left">Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($reservations as $reservation)
                <tr class="border-b hover:bg-gray-50">
                    <td class="py-3">{{ $reservation->id }}</td>
                    <td class="py-3">{{ $reservation->position }}</td>
                    <td class="py-3">{{ $reservation->status }}</td>
                    <td class="py-3">
                        @if($reservation->user_id === auth()->id())
                        <form action="{{ route('reservations.delete', $reservation->id) }}" method="POST"
                              onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
                                Delete
                            </button>
                        </form>
                        @else
                        <span class="text-gray-400 italic">No permission</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

    <div class="mt-4">
        <a href="{{ route('books.list') }}" class="text-blue-600 hover:underline">← Back to Books</a>
    </div>
</div>
@endsection
