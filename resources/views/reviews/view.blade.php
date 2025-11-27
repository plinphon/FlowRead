<div x-data="{ open: false }">
    <button
        @click="modalOpen = true; selectedReview = {{ $review ?? 'null' }}; selectedReservation = {{ $reservation->id }};"
        class="bg-orange-500 text-white px-3 py-1.5 rounded-lg hover:bg-orange-600">
        {{ $review ? 'View Review' : 'Write Review' }}
    </button>

    <!-- Modal -->
    <div 
        x-show="open"
        x-cloak
        @click.self="open = false"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">

        <div class="bg-white rounded-xl w-full max-w-md p-6 relative max-h-[80vh] overflow-y-auto shadow-xl">

            <!-- Close button -->
            <button @click="open = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                ✖
            </button>

            <h2 class="text-xl font-bold mb-4 text-gray-900">Your Review</h2>

            <!-- Rating -->
            <div class="mb-4">
                <p class="text-sm font-semibold text-gray-700 mb-1">Rating</p>
                <div class="flex items-center">
                    @for ($i = 1; $i <= 5; $i++)
                        <span class="text-2xl {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}">⭐</span>
                    @endfor
                    <span class="ml-2 text-sm text-gray-600">({{ $review->rating }}/5)</span>
                </div>
            </div>

            <!-- Content -->
            <div class="mb-4">
                <p class="text-sm font-semibold text-gray-700 mb-1">Review</p>
                <p class="text-gray-700 text-sm leading-relaxed">{{ $review->content }}</p>
            </div>

            <!-- Date -->
            <p class="text-gray-400 text-xs mb-4">Reviewed on {{ $review->created_at->format('M d, Y H:i') }}</p>

            <div class="flex justify-end">
                <button @click="open = false"
                        class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 transition">
                    Close
                </button>
            </div>

        </div>
    </div>
</div>
