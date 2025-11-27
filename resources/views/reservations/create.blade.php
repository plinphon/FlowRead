<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Reservation - FlowRead</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #fffaf5;
        }
    </style>
</head>
<body>

<div class="container mx-auto mt-8 px-4 max-w-2xl pb-12">
    <!-- Header -->
    <div class="mb-8 pb-6 border-b-2 border-orange-200">
        <h1 class="text-3xl font-bold text-gray-900 mb-1">Add Reservation</h1>
        <p class="text-gray-600 text-sm">Reserve "{{ $book->title }}"</p>
    </div>

    <!-- Card -->
    <div class="bg-white border border-gray-200 rounded-xl p-6">
        @if($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <ul class="list-disc list-inside text-red-700 text-sm">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('reservations.store', $book->id) }}">
            @csrf

            <div class="bg-orange-50 border border-orange-200 rounded-lg p-4 mb-6">
                <p class="text-orange-800 text-sm">
                    <span class="font-semibold">Note:</span> You're about to reserve this book. You'll be added to the queue.
                </p>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('reservations.listUI', $book->id) }}" 
                   class="flex-1 bg-gray-100 text-gray-700 px-4 py-2.5 rounded-lg hover:bg-gray-200 transition text-center font-medium">
                    Cancel
                </a>
                <button type="submit" 
                        class="flex-1 bg-orange-500 text-white px-4 py-2.5 rounded-lg hover:bg-orange-600 transition font-medium">
                    Confirm Reservation
                </button>
            </div>
        </form>
    </div>

    <!-- Back Link -->
    <div class="mt-6">
        <a href="{{ route('reservations.listUI', $book->id) }}" class="inline-flex items-center text-orange-600 hover:text-orange-700 font-medium transition text-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Reservations
        </a>
    </div>
</div>

</body>
</html>