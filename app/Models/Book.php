<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'isbn',
        'author_id',
        'category_id',
        'description',
        'cover', // <-- keep this
        'total_copies',
        'available_copies',
        'published_at',
    ];

    // Casts
    protected $casts = [
        'cover' => 'array',       // cover stored as array
        'published_at' => 'date', // ensures Carbon instance
    ];

    // Relationships
    public function author()
    {
        return $this->belongsTo(Author::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function loans()
    {
        return $this->hasMany(Loan::class);
    }
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
