<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $fillable=['nombre','email','direccion','estado'];

    public function alumno(){
	  return $this->belongsTo('App\Alumno');
	}
	public function maestro(){
	  return $this->belongsTo('App\Maestro');
	}
}
