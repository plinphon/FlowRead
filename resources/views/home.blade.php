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

                </tr>
                @endforeach
            </tbody>

        </table>
    </div>
</div>
@endsection
