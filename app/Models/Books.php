<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Books extends Model
{
    use HasFactory;

    protected $fillable = ['email','hospital', 'vaccineI', 'priceI' ,'vaccineII', 'priceII','total_price'];

    function users()
    {
        return $this->hasMany(User::class);
    }
}
