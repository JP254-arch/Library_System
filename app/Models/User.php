<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name','email','password','role'
    ];

    protected $hidden = [
        'password','remember_token',
    ];

    public function loans(){ return $this->hasMany(\App\Models\Loan::class); }
    public function reservations(){ return $this->hasMany(\App\Models\Reservation::class); }

    public function isAdmin(){ return $this->role === 'admin'; }
    public function isLibrarian(){ return $this->role === 'librarian'; }
    public function isMember(){ return $this->role === 'member'; }
}
