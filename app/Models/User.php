<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role'];
    protected $hidden = ['password', 'remember_token'];

    public function buyer()
    {
        return $this->hasOne(Buyer::class);
    }

    public function store()
    {
        return $this->hasOne(Store::class);
    }

    public function isAdmin() {
        return $this->role === 'admin';
    }

    public function isSeller() {
        return $this->store !== null;
    }

    public function isMember() {
        return $this->role === 'member';
    }
}