@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-lg mt-10 bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-6">Add New Book</h1>

    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('books.create') }}">
        @csrf

        <div class="mb-4">
            <label for="title" class="block mb-1 font-medium">Title</label>
            <input type="text" name="title" id="title" value="{{ old('title') }}"
                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">
        </div>

        <div class="mb-4">
            <label for="author" class="block mb-1 font-medium">Author</label>
            <input type="text" name="author" id="author" value="{{ old('author') }}"
                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">
        </div>

        <div class="mb-4">
            <label for="isbn" class="block mb-1 font-medium">ISBN (optional)</label>
            <input type="text" name="isbn" id="isbn" value="{{ old('isbn') }}"
                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">
        </div>

        <input type="hidden" name="owner_id" value="{{ auth()->id() }}">

        <div class="flex justify-between items-center">
            <a href="{{ route('books.list') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">
                Cancel
            </a>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Add Book
            </button>
        </div>
    </form>
</div>
@endsection
