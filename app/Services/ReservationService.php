<?php

namespace App\Services;

use App\Models\Reservation;

class ReservationService
{
    public static function attachAllowedActions($reservations, $context)
    {
        return $reservations->transform(function ($r) use ($context) {
            $allowed = [];

            $userId = $context['user_id'];
            $ownerId = $context['owner_id'];
            $nextPending = $context['next_pending'];
            $hasReading = $context['has_reading'];

            // Cancel
            if (!in_array($r->status, [Reservation::STATUS_COMPLETED, Reservation::STATUS_CANCELED])) {
                if ($userId === $r->user_id || $userId === $ownerId) {
                    $allowed[] = Reservation::STATUS_CANCELED;
                }
            }

            // Reading: only owner, only next pending, only if no current reading
            if ($userId === $ownerId && !$hasReading &&
                $r->status === Reservation::STATUS_PENDING &&
                $r->id === optional($nextPending)->id) {
                $allowed[] = Reservation::STATUS_READING;
            }

            // Completed: only owner on reading reservation
            if ($userId === $ownerId && $r->status === Reservation::STATUS_READING) {
                $allowed[] = Reservation::STATUS_COMPLETED;
            }

            $r->allowedStatuses = $allowed;
            return $r;
        });
    }
}