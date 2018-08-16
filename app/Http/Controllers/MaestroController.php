<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Persona;
use App\Maestro;
use DB;
class MaestroController extends Controller
{
    public function index(Request $request){
    	if(!$request->ajax()){return redirect("/");}
    	$criterio=$request->criterio;
    	$buscar=$request->buscar;
    	$maestros=Maestro::join('personas','maestros.id','=','personas.id')
    	->select('personas.id','personas.nombre','personas.email','personas.direccion','personas.estado','maestros.num_empleado','maestros.tipo')
    	->where($criterio,'LIKE','%'.$buscar.'%')
    	->where('personas.estado','=','1')
    	->orderBy('personas.id','desc')
    	->paginate(7);

    	  return [
    		'pagination'=>[
    			'total'=>$maestros->total(),
    			'current_page'=>$maestros->currentPage(),
    			'per_page'=>$maestros->perPage(),
    			'last_page'=>$maestros->lastPage(),
    			'from'=>$maestros->firstItem(),
    			'to'=>$maestros->lastPage()
    		]
    		,'maestros'=>$maestros
    	];
    }
    public function store(Request $request){
    	if(!$request->ajax()){return redirect("/");}

    	DB::beginTransaction();
	    try{
	    	$persona=new Persona();
	    	$maestro=new Maestro();
	    	$persona->nombre=$request->nombre;
	    	$persona->email=$request->email;
	    	$persona->direccion=$request->direccion;
	    	$persona->estado=1;
	    	$persona->save();
	    	$maestro->id=$persona->id;
	    	$maestro->num_empleado=$request->num_empleado;
	    	$maestro->tipo=$request->tipo;
	    	$maestro->save();
			DB::commit();
		} 
		catch (\Exception $e){
			DB::rollback();
		}
	}
	public function update(Request $request){
    	if(!$request->ajax()){return redirect("/");}

    	DB::beginTransaction();
	    try{
	    	$persona=Persona::findOrFail($request->id);
	    	$maestro=Maestro::findOrFail($persona->id);
	    	$persona->nombre=$request->nombre;
	    	$persona->email=$request->email;
	    	$persona->direccion=$request->direccion;
	    	$persona->estado=1;
	    	$persona->save();
	    	$maestro->id=$persona->id;
	    	$maestro->num_empleado=$request->num_empleado;
	    	$maestro->tipo=$request->tipo;
	    	$maestro->save();
			DB::commit();
		} 
		catch (\Exception $e){
			DB::rollback();
		}
	}

	public function destroy(Request $request){
		if(!$request->ajax()){return redirect("/");}
		$persona=Persona::findOrFail($request->id);
		$persona->estado=0;
		$persona->save();
	}	
}
