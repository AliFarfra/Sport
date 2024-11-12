<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['id_user', 'role'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
