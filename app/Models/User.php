<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'id_adherent',
        'id_administrateur',
    ];
    public function adherent()
    {
        return $this->hasOne(Adherent::class, 'id', 'id_adherent');
    }
    // Relationship with roles
    public function roles()
    {
        return $this->hasMany(Role::class, 'id_user'); // Assuming your roles table has 'id_user' as the foreign key
    }

    // Method to check if the user has a specific role
    public function hasRole($role)
    {
        return $this->roles()->where('role', $role)->exists(); // Check if the user has the specified role
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}