<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    protected $fillable=['id','matricula','carrera','grupo'];
    
    public $timestamps=false;

    public function persona() {
	  return $this->hasOne('App\Persona');
	}
}
