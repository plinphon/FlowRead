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
                    <th class="py-3 text-left">User</th>
                    <th class="py-3 text-left">Position</th>
                    <th class="py-3 text-left">Status</th>
                    <th class="py-3 text-left">Booked At</th>
                    <th class="py-3 text-left">Actions</th>
                </tr>
            </thead>

            <tbody>
            @foreach ($reservations as $reservation)
                @php
                    $rowClass = '';
                    if ($reservation->status === \App\Models\Reservation::STATUS_READING) {
                        $rowClass = 'bg-green-100';
                    } elseif ($nextPending && $reservation->id === $nextPending->id) {
                        $rowClass = 'bg-yellow-100';
                    }
                @endphp

                <tr class="border-b hover:bg-gray-50 {{ $rowClass }}">
                    <td>{{ $reservation->id }}</td>
                    <td>{{ $reservation->user->username ?? 'User' }}</td>
                    <td>{{ $reservation->position }}</td>
                    <td>{{ ucfirst($reservation->status) }}</td>
                    <td>{{ $reservation->created_at->format('Y-m-d H:i') }}</td>
                    <td>
                        @if(!empty($reservation->allowedStatuses))
                            <form action="{{ route('reservations.updateStatus', $reservation->id) }}" method="POST" class="flex gap-2">
                                @csrf
                                @method('PUT')
                                <select name="status" class="border rounded px-2 py-1">
                                    @foreach($reservation->allowedStatuses as $status)
                                        <option value="{{ $status }}" {{ $reservation->status === $status ? 'selected' : '' }}>
                                            {{ ucfirst($status) }}
                                        </option>
                                    @endforeach
                                </select>
                                <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">
                                    Update
                                </button>
                            </form>
                        @else
                            <span class="text-gray-400 italic">{{ ucfirst($reservation->status) }}</span>
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
