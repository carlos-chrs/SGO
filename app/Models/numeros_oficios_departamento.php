<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Numeros_oficios_departamento extends Model
{
    use HasFactory;
    protected $table = 'numeros_oficios_departamento';
    protected $fillable = ['contador'];
}
