<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adherent extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'prenom', 'date_naissance', 'cin'];
    protected $casts = [
        'date_naissance' => 'date',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id_adherent'); // Correct foreign key
    }

    public function subscriptions()
    {
        // Use this if you want to fetch subscriptions through the user
        return $this->hasManyThrough(Subscription::class, User::class, 'id_adherent', 'user_id');
    }
}