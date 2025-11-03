<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = ['book_id','user_id','borrowed_at','due_at','returned_at','fine_amount','status'];

    protected $casts = [
        'borrowed_at' => 'datetime',
        'due_at' => 'datetime',
        'returned_at' => 'datetime',
    ];

    public function book(){ return $this->belongsTo(Book::class); }
    public function user(){ return $this->belongsTo(User::class); }
}
