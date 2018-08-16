<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Alumno;
use App\Persona;
use DB;
use Storage;
use Excel;
use Auth;

class AlumnoController extends Controller
{

    public function index(Request $request){
    	if(!$request->ajax()){return redirect("/main");}
    	$criterio=$request->criterio;
    	$buscar=$request->buscar;
    	$alumnos=Alumno::join('personas','alumnos.id','=','personas.id')
    	->select('personas.id','personas.nombre','personas.email','personas.direccion','personas.estado','alumnos.matricula','alumnos.carrera','alumnos.grupo')
    	->where($criterio,'LIKE','%'.$buscar.'%')
    	->where('personas.estado','=','1')
    	->orderBy('personas.id','desc')
    	->paginate(7);

    	  return [
    		'pagination'=>[
    			'total'=>$alumnos->total(),
    			'current_page'=>$alumnos->currentPage(),
    			'per_page'=>$alumnos->perPage(),
    			'last_page'=>$alumnos->lastPage(),
    			'from'=>$alumnos->firstItem(),
    			'to'=>$alumnos->lastPage()
    		]
    		,'alumnos'=>$alumnos
    	];

    }
    public function store(Request $request){
    	if(!$request->ajax()){return redirect("/main");}
    	DB::beginTransaction();
	    try{
	    	$persona=new Persona();
	    	$alumno=new Alumno();
	    	$persona->nombre=$request->nombre;
	    	$persona->email=$request->email;
	    	$persona->direccion=$request->direccion;
	    	$persona->estado=1;
	    	$persona->save();
	    	$alumno->id=$persona->id;
	    	$alumno->matricula=$request->matricula;
	    	$alumno->carrera=$request->carrera;
	    	$alumno->grupo=$request->grupo;
	    	$alumno->save();
			DB::commit();
		} 
		catch (\Exception $e){
			DB::rollback();
		}
	}
	public function update(Request $request){
    	if(!$request->ajax()){return redirect("/main");}

    	DB::beginTransaction();
	    try{
	    	$persona=Persona::findOrFail($request->id);
	    	$alumno=Alumno::findOrFail($persona->id);
	    	$persona->nombre=$request->nombre;
	    	$persona->email=$request->email;
	    	$persona->direccion=$request->direccion;
	    	$persona->estado=1;
	    	$persona->save();
	    	$alumno->id=$persona->id;
	    	$alumno->matricula=$request->matricula;
	    	$alumno->carrera=$request->carrera;
	    	$alumno->grupo=$request->grupo;
	    	$alumno->save();
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

	public function import(Request $request){
		$archivo = $request->file('archivo');
       	$nombre_original=$archivo->getClientOriginalName();
	   	$extension=$archivo->getClientOriginalExtension();
       	$save=Storage::disk('archivos')->put($nombre_original, \File::get($archivo) );
       	$ruta  =  storage_path('archivos') ."/". $nombre_original;
       	if($save){
       		Excel::load($ruta,function($archivo){
       			$result=$archivo->get();

       			foreach ($result as $key => $value) {
       				$alumnos=Alumno::where("matricula","=",$value->matricula)->get();
			        if(count( $alumnos)==0){
			        	$persona=new Persona();
				    	$alumno=new Alumno();
				    	$persona->nombre=$value->nombre;
				    	$persona->email=$value->email;
				    	$persona->direccion=$value->direccion;
				    	$persona->estado=1;
				    	$persona->save();
				    	$alumno->id=$persona->id;
				    	$alumno->matricula=$value->matricula;
				    	$alumno->carrera=$value->carrera;
				    	$alumno->grupo=$value->grupo;
				    	$alumno->save();
	                }
       			}
       		})->get();
        }
	}

	public function getCarrera(){
		$alumnos=Alumno::join('personas','personas.id','=','alumnos.id')->where('estado','=','1')->
		where('grupo','=','SC91')->get();

		return $alumnos;
	}
}
