@extends('layouts.app')

@section('title', 'FlowRead - Add New Book')

@section('content')
<div class="container mx-auto mt-8 px-4 max-w-2xl pb-12">
    <!-- Header -->
    <div class="mb-8 pb-6 border-b-2 border-orange-200">
        <h1 class="text-3xl font-bold text-gray-900 mb-1">Add New Book</h1>
        <p class="text-gray-600 text-sm">Share a book with the community</p>
    </div>

    <!-- Card -->
    <div class="bg-white border border-gray-200 rounded-xl p-6">
        @if($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                <ul class="list-disc list-inside text-red-700 text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('books.create') }}" class="space-y-5">
            @csrf

            <div>
                <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">Title *</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition"
                    placeholder="Enter book title" required>
            </div>

            <div>
                <label for="author" class="block text-sm font-semibold text-gray-700 mb-2">Author *</label>
                <input type="text" name="author" id="author" value="{{ old('author') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition"
                    placeholder="Enter author name" required>
            </div>

            <div>
                <label for="isbn" class="block text-sm font-semibold text-gray-700 mb-2">ISBN (optional)</label>
                <input type="text" name="isbn" id="isbn" value="{{ old('isbn') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition"
                    placeholder="Enter ISBN number">
            </div>

            <input type="hidden" name="owner_id" value="{{ auth()->id() }}">

            <div class="flex gap-3 pt-4">
                <a href="{{ route('books.list') }}" 
                   class="flex-1 bg-gray-100 text-gray-700 px-4 py-2.5 rounded-lg hover:bg-gray-200 transition text-center font-medium">
                    Cancel
                </a>
                <button type="submit" 
                        class="flex-1 bg-orange-500 text-white px-4 py-2.5 rounded-lg hover:bg-orange-600 transition font-medium">
                    Add Book
                </button>
            </div>
        </form>
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
@endsection
