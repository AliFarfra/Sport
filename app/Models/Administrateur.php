<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Administrateur extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'prenom', 'date_debut', 'matricule', 'type'];
    protected $casts = [
        'date_debut' => 'date', // Cast to date
    ];
    public function user()
    {
        return $this->hasOne(User::class, 'id_administrateur');
    }
}