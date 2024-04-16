<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vehiculo_mod extends Model
{
    use HasFactory;
    public function vehiculo()
    {
        return $this->belongsTo(vehiculo_marca::class);
    }
}
