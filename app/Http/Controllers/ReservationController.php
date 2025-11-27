<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Book;
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

        //next pending reservation
        $nextPending = $reservations->where('status', Reservation::STATUS_PENDING)->sortBy('position')->first();

        $reservations->transform(function($reservation) use ($userId, $bookOwnerId, $nextPending) {
            $allowed = [];

            //cancel allowed for user or owner if not completed/canceled
            if (!in_array($reservation->status, [Reservation::STATUS_COMPLETED, Reservation::STATUS_CANCELED])) {
                if ($userId === $reservation->user_id || $userId === $bookOwnerId) {
                    $allowed[] = Reservation::STATUS_CANCELED;
                }
            }

            //owner can move next pending to reading
            if ($userId === $bookOwnerId
                && $reservation->status === Reservation::STATUS_PENDING
                && $reservation->id === optional($nextPending)->id
            ) {
                $allowed[] = Reservation::STATUS_READING;
            }

            //owner can mark reading reservation as completed
            if ($userId === $bookOwnerId && $reservation->status === Reservation::STATUS_READING) {
                $allowed[] = Reservation::STATUS_COMPLETED;
            }

            $reservation->allowedStatuses = $allowed;
            return $reservation;
        });

        return view('reservations.list', compact('book', 'reservations', 'nextPending'));
    }



    /**
     * Show create reservation form for a book
     */
    public function createUI(string $book_id)
    {
        $book = Book::findOrFail($book_id);
        return view('reservations.create', compact('book'));
    }

    /**
     * Store a new reservation
     */
    public function store(Request $request, string $book_id)
    {
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
        $allowed = $reservation->getAllowedStatusesForUser(auth()->id());

        $status = strtolower($request->status);

        if (!in_array($status, $allowed)) {
            return back()->with('error', 'You cannot change the reservation to this status.');
        }

        $reservation->update(['status' => $status]);

        return back()->with('success', 'Reservation status updated!');
    }

}
