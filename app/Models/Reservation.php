<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $table = 'reservations';

    protected $fillable = [
        'book_id',
        'user_id',
        'position',
        'status',
    ];

    // Allowed status values
    public const STATUS_PENDING = 'pending';
    public const STATUS_CANCELED = 'canceled';
    public const STATUS_READING = 'reading';
    public const STATUS_COMPLETED = 'completed';

    public function getAllowedStatusesForUser($userId)
    {
        $allowed = [];

        $bookOwnerId = $this->book->owner_id;

        // Cancel: only pending
        if ($this->status === self::STATUS_PENDING) {
            $allowed[] = self::STATUS_CANCELED;
        }

        // Reading: only book owner and next pending
        $nextPending = self::where('book_id', $this->book_id)
            ->where('status', self::STATUS_PENDING)
            ->orderBy('position')
            ->first();

        if ($userId === $bookOwnerId 
            && $this->status === self::STATUS_PENDING 
            && $nextPending && $this->id === $nextPending->id
        ) {
            $allowed[] = self::STATUS_READING;
        }

        // Completed: only book owner and currently reading
        if ($userId === $bookOwnerId && $this->status === self::STATUS_READING) {
            $allowed[] = self::STATUS_COMPLETED;
        }

        return $allowed;
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
