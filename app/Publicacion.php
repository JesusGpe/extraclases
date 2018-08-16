<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Publicacion extends Model
{	protected $table='publicaciones';
    protected $fillable=['id','idextraclase','idpersona','publicacion','imagen',];
}
