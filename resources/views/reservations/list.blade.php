<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservations - FlowRead</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #fffaf5;
        }
    </style>
</head>
<body>

<div class="container mx-auto mt-8 px-4 pb-12 max-w-7xl">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8 pb-6 border-b-2 border-orange-200">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-1">Reservations</h1>
            <p class="text-gray-600 text-sm">{{ $book->title }}</p>
        </div>
        <a href="{{ route('reservations.createUI', $book->id) }}"
           class="bg-orange-500 text-white px-6 py-2.5 rounded-lg hover:bg-orange-600 transition font-medium">
           + Add Reservation
        </a>
    </div>

    <!-- Reservations Table -->
    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
        @if($reservations->isEmpty())
            <div class="text-center py-12">
                <div class="text-4xl mb-3">📋</div>
                <p class="text-gray-500">No reservations yet. Be the first to reserve!</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">ID</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">User</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Position</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Booked At</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                    @foreach ($reservations as $reservation)
                        @php
                            $rowClass = '';
                            if ($reservation->status === \App\Models\Reservation::STATUS_READING) {
                                $rowClass = 'bg-green-50';
                            } elseif ($nextPending && $reservation->id === $nextPending->id) {
                                $rowClass = 'bg-yellow-50';
                            }
                        @endphp

                        <tr class="hover:bg-gray-50 transition {{ $rowClass }}">
                            <td class="px-4 py-4 text-sm text-gray-900">{{ $reservation->id }}</td>
                            <td class="px-4 py-4 text-sm font-medium text-gray-900">{{ $reservation->user->username ?? 'User' }}</td>
                            <td class="px-4 py-4 text-sm text-gray-600">{{ $reservation->position }}</td>
                            <td class="px-4 py-4">
                                <span class="px-2.5 py-1 rounded-full text-xs font-medium
                                    @if($reservation->status === \App\Models\Reservation::STATUS_READING)
                                        bg-green-100 text-green-700
                                    @elseif($reservation->status === 'pending')
                                        bg-yellow-100 text-yellow-700
                                    @else
                                        bg-gray-100 text-gray-700
                                    @endif
                                ">
                                    {{ ucfirst($reservation->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-4 text-sm text-gray-600">{{ $reservation->created_at->format('M d, Y H:i') }}</td>
                            <td class="px-4 py-4">
                                @if(!empty($reservation->allowedStatuses))
                                    <form action="{{ route('reservations.updateStatus', $reservation->id) }}" method="POST" class="flex gap-2 items-center">
                                        @csrf
                                        @method('PUT')
                                        <select name="status" class="border border-gray-300 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
                                            @foreach($reservation->allowedStatuses as $status)
                                                <option value="{{ $status }}" {{ $reservation->status === $status ? 'selected' : '' }}>
                                                    {{ ucfirst($status) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <button type="submit" class="bg-orange-500 text-white px-3 py-1.5 rounded-lg hover:bg-orange-600 transition text-sm font-medium">
                                            Update
                                        </button>
                                    </form>
                                @else
                                    <span class="text-gray-400 italic text-sm">No actions</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <!-- Back Link -->
    <div class="mt-6">
        <a href="{{ route('books.list') }}" class="inline-flex items-center text-orange-600 hover:text-orange-700 font-medium transition text-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Books
        </a>
    </div>
</div>

</body>
</html>