<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Book;
use App\Services\ReservationService;
use App\Models\Review;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function list(string $book_id)
    {
        $book = Book::findOrFail($book_id);

        $reservations = Reservation::where('book_id', $book_id)
            ->orderBy('position')
            ->get();

        $userId = auth()->id();
        $bookOwnerId = $book->owner_id;

        $nextPending = $reservations->where('status', Reservation::STATUS_PENDING)->sortBy('position')->first();
        $currentReading = $reservations->where('status', Reservation::STATUS_READING)->first();

        // Build allowed actions map for frontend
        $allowedActions = [];
        foreach ($reservations as $reservation) {
            $allowedActions[$reservation->id] = \App\Services\ReservationService::getAllowedActions(
                $reservation,
                [
                    'user_id' => $userId,
                    'owner_id' => $bookOwnerId,
                    'next_pending' => $nextPending,
                    'has_reading' => $currentReading !== null,
                ]
            );
        }

        $reviews = Review::where('book_id', $book_id)
            ->get()
            ->keyBy('reservation_id');

        return view('reservations.list', compact('book', 'reservations', 'nextPending', 'allowedActions', 'reviews'));
    }

    /**
     * Show create reservation form for a book
     */
    public function createUI(string $book_id)
    {
        $book = Book::findOrFail($book_id);
        $this->authorize('create', $book); 
        return view('reservations.create', compact('book'));
    }

    /**
     * Store a new reservation
     */
    public function store(Request $request, string $book_id)
    {
        $book = Book::findOrFail($book_id);

       $this->authorize('create', $book); 

        $lastReservation = Reservation::where('book_id', $book_id)
            ->orderByDesc('position')
            ->first();

        $position = $lastReservation ? $lastReservation->position + 1 : 1;


        Reservation::create([
            'book_id' => $book_id,
            'user_id' => auth()->id(),
            'position' => $position,
            'status' => 'pending',
        ]);

        return redirect()->route('reservations.listUI', $book_id)
                        ->with('success', 'Reservation created!');
    }


    /**
     * Update reservation status
     */
    public function updateStatus(Request $request, string $id)
    {
        $reservation = Reservation::findOrFail($id);
        $status = strtolower($request->status);

        // Check using service, no need for policy duplication
        if (!ReservationService::canUpdateStatus($reservation, auth()->id(), $status)) {
            abort(403, 'Not allowed to change this status.');
        }

        $reservation->status = $status;
        $reservation->save();

        return back()->with('success', 'Reservation status updated!');
    }
}
