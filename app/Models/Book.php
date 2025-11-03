<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title','isbn','author_id','category_id','description','total_copies','available_copies','cover_path','published_at'
    ];

    public function author(){ return $this->belongsTo(Author::class); }
    public function category(){ return $this->belongsTo(Category::class); }
    public function loans(){ return $this->hasMany(Loan::class); }
    public function reservations(){ return $this->hasMany(Reservation::class); }
}
