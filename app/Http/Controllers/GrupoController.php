<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Grupo;
use DB;
class GrupoController extends Controller
{
    public function index(Request $request){
        //if(!$request->ajax()){return redirect("/");}
        $criterio="grupos.nombre";
        $buscar=$request->buscar;
        $grupos=Grupo::join('carreras','carreras.id','=','grupos.idcarrera')
        ->select('grupos.id','grupos.nombre as grupo','carreras.nombre as carrera')
        ->where($criterio,'LIKE','%'.$buscar.'%')
        ->where('grupos.estado','=','1')
        ->orderBy('grupos.id','desc')
        ->paginate(7);
    
        return [
            'pagination'=>[
                'total'=>$grupos->total(),
                'current_page'=>$grupos->currentPage(),
                'per_page'=>$grupos->perPage(),
                'last_page'=>$grupos->lastPage(),
                'from'=>$grupos->firstItem(),
                'to'=>$grupos->lastPage()
            ]
            ,'grupos'=>$grupos
        ];
       }
    public function store(Request $request){
        if(!$request->ajax()){return redirect("/");}
        $nombre=$request->nombre;

        DB::beginTransaction();
        try{
            $grupo=new Grupo();
            $grupo->idcarrera=$request->idcarrera;
            $grupo->nombre=$request->nombre;
            $grupo->estado=1;
            $grupo->save();
            DB::commit();
        } 
        catch (\Exception $e){
            DB::rollback();
        }

        return $nombre;
    }
    public function update(Request $request){
        if(!$request->ajax()){return redirect("/");}
        DB::beginTransaction();
        try{
            $grupo=Grupo::findOrFail($request->id);
            $grupo->idcarrera=$request->idcarrera;
            $grupo->nombre=$request->nombre;
            $grupo->estado=1;
            $grupo->save();
            DB::commit();
        } 
        catch (\Exception $e){
            DB::rollback();
        }
    }
    public function destroy(Request $request){
        $grupo=Grupo::findOrFail($request->id);
        $grupo->estado=0;
        $grupo->save();
    }
}
