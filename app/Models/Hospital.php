<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'name', 'status', 'address'];

    function vaccines()
    {
        return $this->belongsToMany(Vaccine::class);
    }
}
