<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampoDocumento extends Model
{
    use HasFactory;

    protected $table = 'campo_doc';
    protected $fillable = ['nombre','alineacion','text','id_fuente','size','isBold', 'isUnderline', 'nombreVisible'];
}
