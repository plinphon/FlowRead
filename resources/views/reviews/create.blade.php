@extends('layouts.app')

@section('title', 'Write Review')

@section('content')
<div class="max-w-xl mx-auto mt-12 bg-white p-6 rounded-xl shadow">

    <h1 class="text-2xl font-bold mb-4">Write Your Review</h1>

    <form action="{{ route('reviews.store', $reservation->id) }}" method="POST">
        @csrf

        <!-- Rating -->
        <label class="font-semibold">Rating</label>
        <select name="rating" required class="w-full border rounded-lg px-3 py-2 mb-4">
            <option value="">Select rating</option>
            @for($i = 1; $i <= 5; $i++)
                <option value="{{ $i }}">{{ $i }} ⭐</option>
            @endfor
        </select>

        <!-- Content -->
        <label class="font-semibold">Review</label>
        <textarea
            name="content"
            rows="5"
            required
            class="w-full border rounded-lg px-3 py-2"
            placeholder="Write your thoughts about this book..."
        ></textarea>

        <div class="flex justify-end mt-4">
            <button type="submit" class="bg-orange-500 text-white px-4 py-2 rounded-lg hover:bg-orange-600">
                Submit Review
            </button>
        </div>
    </form>

</div>
@endsection
