<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Book;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * List all reservations for a book (only for logged-in user if needed)
     */
    public function list(string $book_id)
    {
        $book = Book::findOrFail($book_id);

        $reservations = Reservation::where('book_id', $book_id)
            ->where('user_id', auth()->id()) //only user's reservations
            ->get();

        return view('reservations.list', compact('book', 'reservations'));
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
     * Delete a reservation (only owner can delete)
     */
    public function destroy(string $id)
    {
        $reservation = Reservation::findOrFail($id);

        if ($reservation->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $reservation->delete();

        return back()->with('success', 'Reservation deleted!');
    }
}
