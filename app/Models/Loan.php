<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'user_id',
        'borrowed_at',
        'due_at',
        'returned_at',
        'fine',
        'amount',
        'total',
        'is_paid',
        'status'
    ];

    protected $casts = [
        'borrowed_at' => 'datetime',
        'due_at' => 'datetime',
        'returned_at' => 'datetime',
        'is_paid' => 'boolean',
    ];

    const FINE_PER_DAY = 70;

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Check if loan is overdue
    public function getIsOverdueAttribute()
    {
        return !$this->returned_at && $this->due_at && now()->greaterThan($this->due_at);
    }

    // Dynamic fine calculation (avoiding recursion)
    public function getFineAttribute($value)
    {
        // If already returned, use stored fine
        if ($this->status === 'returned') {
            return $this->attributes['fine'] ?? 0;
        }

        // Calculate dynamically if overdue
        if ($this->isOverdue) {
            $daysOverdue = $this->due_at->diffInDays(now());
            return $daysOverdue * self::FINE_PER_DAY;
        }

        return 0;
    }

    // Total = amount + fine
    public function getTotalAttribute($value)
    {
        $baseAmount = $this->amount ?? 500;
        return $baseAmount + $this->fine;
    }

    // Status label for dashboards
    public function getStatusLabelAttribute()
    {
        if ($this->status === 'returned')
            return 'Returned';
        return $this->isOverdue ? 'Overdue' : 'Borrowed';
    }

    // Payment label
    public function getPaymentLabelAttribute()
    {
        return $this->is_paid ? 'Paid' : 'Unpaid';
    }
}
