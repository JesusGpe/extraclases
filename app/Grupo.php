<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    protected $fillable=['idcarrera','nombre'];
    public $timestamps=false;
    
    public function carrera() {
	  return $this->belongsTo('App\Carrera');
	}
}
