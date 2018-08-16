<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Carrera;
use DB;
class CarreraController extends Controller
{
    public function index(Request $request){
        if(!$request->ajax()){return redirect("/");}
        $criterio=$request->criterio;
        $buscar=$request->buscar;
        $carreras=Carrera::where($criterio,'LIKE','%'.$buscar.'%')
        ->where('estado','=','1')
        ->orderBy('id','desc')
        ->paginate(7);
    
        return [
            'pagination'=>[
                'total'=>$carreras->total(),
                'current_page'=>$carreras->currentPage(),
                'per_page'=>$carreras->perPage(),
                'last_page'=>$carreras->lastPage(),
                'from'=>$carreras->firstItem(),
                'to'=>$carreras->lastPage()
            ]
            ,'carreras'=>$carreras
        ];
       }
    public function store(Request $request){
        if(!$request->ajax()){return redirect("/");}
        DB::beginTransaction();
        try{
            $carrera=new Carrera();
            $carrera->nombre=$request->nombre;
            $carrera->descripcion=$request->descripcion;
            $carrera->estado=1;
            $carrera->save();
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
            $carrera=Carrera::findOrFail($request->id);
            $carrera->nombre=$request->nombre;
            $carrera->descripcion=$request->descripcion;
            $carrera->estado=1;
            $carrera->save();
            DB::commit();
        } 
        catch (\Exception $e){
            DB::rollback();
        }
    }
    public function destroy(Request $request){
        $carrera=Carrera::findOrFail($request->id);
        $carrera->estado=0;
        $carrera->save();
    }

    public function getCarrera(){
        $carreras=Carrera::where('estado','=','1')
        ->get();

        return ['carreras'=>$carreras];
    }
}
