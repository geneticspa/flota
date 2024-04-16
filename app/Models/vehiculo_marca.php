<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vehiculo_marca extends Model
{
    use HasFactory;
    public function vehiculo_marca()
    {
        return $this->hasMany(vehiculo_mod::class);
    }
}
