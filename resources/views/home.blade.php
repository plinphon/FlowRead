@extends('layouts.app')

@section('title', 'FlowRead - Book List')

@section('content')

<div class="container mx-auto mt-8 px-4 pb-12 max-w-7xl">
    <!-- Minimal Header -->
    <div class="flex justify-between items-center mb-12 pb-6 border-b-2 border-orange-200">
        <div>
            <h1 class="text-4xl font-bold text-gray-900 mb-1">FlowRead</h1>
            <p class="text-gray-600 text-sm">Share books, spark conversations</p>
        </div>
        <a href="{{ route('books.createUI') }}"
           class="bg-orange-500 text-white px-6 py-2.5 rounded-lg hover:bg-orange-600 transition font-medium">
           + Add Book
        </a>
    </div>

    <!-- Book Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($books as $book)
        <div class="bg-white border border-gray-200 rounded-xl p-5">
            <!-- Book Title & Author -->
            <div class="mb-4">
                <h2 class="text-xl font-bold text-gray-900 mb-1 line-clamp-2">{{ $book->title }}</h2>
                <p class="text-gray-600 text-sm">{{ $book->author }}</p>
            </div>
            <!-- Book Image -->
            <div class="mb-4 w-full aspect-[2/3]">
                @if($book->image_path)
                    <img src="{{ asset('storage/' . $book->image_path) }}" 
                        alt="{{ $book->title }}" 
                        class="w-full h-full object-cover rounded-lg">
                @else
                    <div class="w-full h-full bg-gray-100 flex items-center justify-center rounded-lg text-gray-400 text-sm">
                        No Image
                    </div>
                @endif
            </div>
            <!-- Owner -->
            <div class="flex items-center gap-2 mb-4 pb-4 border-b border-gray-100">
                <div class="w-8 h-8 bg-orange-100 rounded-full flex items-center justify-center text-orange-600 font-semibold text-sm">
                    {{ strtoupper(substr($book->user->username ?? 'U', 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs text-gray-500">Shared by</p>
                    <p class="text-sm font-medium text-gray-900 truncate">{{ $book->user->username ?? 'Unknown' }}</p>
                </div>
                @if(isset($book->reservations_count) && $book->reservations_count > 0)
                <div class="bg-orange-50 text-orange-600 px-2 py-1 rounded text-xs font-medium">
                    {{ $book->reservations_count }} waiting
                </div>
                @endif
            </div>

            <!-- ISBN (Compact) -->
            @if($book->isbn)
            <div class="mb-4">
                <p class="text-xs text-gray-500">ISBN: <span class="text-gray-700 font-mono">{{ $book->isbn }}</span></p>
            </div>
            @endif

            <!-- Actions -->
            <div class="flex gap-2">
                <!-- Reservations is visible to everyone -->
                <a href="{{ route('reservations.listUI', $book->id) }}"
                    class="flex-1 bg-orange-500 text-white px-3 py-2 rounded-lg hover:bg-orange-600 transition text-center text-sm font-medium">
                    Reservations
                </a>

                @can('update', $book)
                <a href="{{ route('books.editUI', $book->id) }}"
                    class="bg-gray-100 text-gray-700 px-3 py-2 rounded-lg hover:bg-gray-200 transition text-sm font-medium">
                    Edit
                </a>
                @endcan

                @can('delete', $book)
                <form action="{{ route('books.delete', $book->id) }}" method="POST"
                        onsubmit="return confirm('Remove this book?')" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="bg-red-50 text-red-600 px-3 py-2 rounded-lg hover:bg-red-100 transition text-sm font-medium">
                        Delete
                    </button>
                </form>
                @endcan
            </div>

        </div>
        @endforeach
    </div>

    @if ($books->isEmpty())
        <div class="text-center mt-20">
            <div class="inline-block bg-white border-2 border-dashed border-orange-200 rounded-2xl p-12 max-w-md">
                <div class="text-5xl mb-4">📚</div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">No books yet</h3>
                <p class="text-gray-600 mb-6 text-sm">Start sharing your favorite reads</p>
                <a href="{{ route('books.createUI') }}"
                   class="inline-block bg-orange-500 text-white px-6 py-2.5 rounded-lg hover:bg-orange-600 transition font-medium">
                    Add Your First Book
                </a>
            </div>
        </div>
    @endif
</div>

<!-- Minimal Footer -->
<div class="border-t border-orange-100 mt-12">
    <div class="container mx-auto px-4 py-6 max-w-7xl">
        <p class="text-center text-gray-500 text-sm">FlowRead - Keep the conversation flowing 📖</p>
    </div>
</div>

@endsection
