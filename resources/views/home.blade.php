@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-10">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Book List</h1>

        <a href="{{ route('books.createUI') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
           + Add Book
        </a>
    </div>

    <div class="bg-white shadow rounded-lg p-6">
        <table class="min-w-full">
            <thead>
                <tr class="border-b">
                    <th class="py-3 text-left">ID</th>
                    <th class="py-3 text-left">Title</th>
                    <th class="py-3 text-left">Author</th>
                    <th class="py-3 text-left">ISBN</th>
                    <th class="py-3 text-left">Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($books as $book)
                <tr class="border-b hover:bg-gray-50">
                    <td class="py-3">{{ $book->id }}</td>
                    <td class="py-3">{{ $book->title }}</td>
                    <td class="py-3">{{ $book->author }}</td>
                    <td class="py-3">{{ $book->isbn }}</td>

                    <td class="py-3">
                        @if ($book->owner_id === auth()->id())
                            <div class="flex gap-2">
                                <!-- Edit -->
                                <a href="{{ route('books.editUI', $book->id) }}"
                                   class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">
                                    Edit
                                </a>

                                <!-- Delete -->
                                <form action="{{ route('books.delete', $book->id) }}" method="POST"
                                      onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        @else
                            <!-- Non-owner: View reservations button -->
                            <a href="{{ route('reservations.listUI', $book->id) }}"
                               class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">
                                View Reservations
                            </a>
                        @endif
                    </td>

                </tr>
                @endforeach
            </tbody>

        </table>
    </div>
</div>
@endsection
