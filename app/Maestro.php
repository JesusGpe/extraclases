<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Maestro extends Model
{
    protected $fillable=['id','num_empleado','tipo'];
    
    public $timestamps=false;

    public function persona() {
	  return $this->hasOne('App\Persona');
	}
}
