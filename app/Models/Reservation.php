<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'reservations';

    /**
     * @var array
     */
    protected $fillable = [
        'book_id',
        'user_id',
        'position',
        'status'
    ];

    public function book()
    {
        return $this->belongTo(Book::class);
    }

    public function user()
    {
        return $this->belongTo(User::class);
    }
}