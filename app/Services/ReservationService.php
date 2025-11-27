<?php

namespace App\Services;

use App\Models\Reservation;

class ReservationService
{
    /**
     * Get allowed actions for a single reservation
     */
    public static function getAllowedActions(Reservation $reservation, array $context): array
    {
        $allowed = [];

        $userId = $context['user_id'];
        $ownerId = $context['owner_id'];
        $nextPending = $context['next_pending'];
        $hasReading = $context['has_reading'];

        // Cancel (user or owner)
        if (!in_array($reservation->status, [Reservation::STATUS_COMPLETED, Reservation::STATUS_CANCELED, Reservation::STATUS_READING])) {
            if ($userId === $reservation->user_id || $userId === $ownerId) {
                $allowed[] = Reservation::STATUS_CANCELED;
            }
        }

        // Owner moves next pending → reading
        if ($userId === $ownerId
            && $reservation->status === Reservation::STATUS_PENDING
            && optional($nextPending)->id === $reservation->id
            && !$hasReading
        ) {
            $allowed[] = Reservation::STATUS_READING;
        }

        // Owner marks reading → completed
        if ($userId === $ownerId && $reservation->status === Reservation::STATUS_READING) {
            $allowed[] = Reservation::STATUS_COMPLETED;
        }

        return $allowed;
    }

    /**
     * Check if a user can update to a new status
     */
    public static function canUpdateStatus(Reservation $reservation, int $userId, string $newStatus): bool
    {
        $allowed = self::getAllowedActions(
            $reservation,
            [
                'user_id' => $userId,
                'owner_id' => $reservation->book->owner_id,
                'next_pending' => $reservation->book->reservations()
                                            ->where('status', Reservation::STATUS_PENDING)
                                            ->orderBy('position')
                                            ->first(),
                'has_reading' => $reservation->status === Reservation::STATUS_READING,
            ]
        );

        return in_array($newStatus, $allowed);
    }
}
