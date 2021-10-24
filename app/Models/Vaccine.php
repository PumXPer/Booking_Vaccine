<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vaccine extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'name', 'type_id' ,'price', 'description'];

    function type()
    {
        return $this->belongsTo(Type::class);
    }

    function hospitals()
    {
        return $this->belongsToMany(Hospital::class);
    }
}
