<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',  // Use user_id instead of adherent_id
        'pack_id',
        'cours_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pack()
    {
        return $this->belongsTo(Pack::class);
    }

    public function cours()
    {
        return $this->belongsTo(Cours::class);
    }
}