<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fuente extends Model
{
    use HasFactory;
    protected $table = 'fuente';
    protected $fillable = ['nombre','url',];
}
