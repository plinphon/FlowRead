<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Reservation;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{

    public function create(Reservation $reservation)
    {
        //only allow owner of reservation and completed status
        if ($reservation->user_id !== Auth::id() || $reservation->status !== Reservation::STATUS_COMPLETED) {
            abort(403, 'You can only review books for completed reservations.');
        }

        return view('reviews.create', compact('reservation'));
    }

    public function store(Request $request, Reservation $reservation)
    {
        //only allow owner of reservation and completed status
        if ($reservation->user_id !== Auth::id() || $reservation->status !== Reservation::STATUS_COMPLETED) {
            abort(403, 'You can only review books for completed reservations.');
        }

        $request->validate([
            'rating' => 'nullable|integer|min:1|max:5',
            'content' => 'nullable|string|max:2000',
        ]);

        Review::create([
            'book_id' => $reservation->book_id,
            'user_id' => Auth::id(),
            'reservation_id' => $reservation->id,
            'rating' => $request->rating,
            'content' => $request->content,
        ]);

        return redirect()->route('reservations.listUI', $reservation->book_id)
                         ->with('success', 'Review submitted successfully.');
    }
}
