<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $fillable = ['nombre','direccion','provincia','localidad','CIF/NIF','email','telefono','cp'];
}
