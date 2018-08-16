<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Extraclase;
use DB;
class ExtraclaseController extends Controller
{
   public function index(Request $request){
    if(!$request->ajax()){return redirect("/");}
    $criterio=$request->criterio;
    $buscar=$request->buscar;
    $extraclases=Extraclase::where($criterio,'LIKE','%'.$buscar.'%')
    ->where('estado','=','1')
    ->orderBy('id','desc')
    ->paginate(7);

    return [
        'pagination'=>[
            'total'=>$extraclases->total(),
            'current_page'=>$extraclases->currentPage(),
            'per_page'=>$extraclases->perPage(),
            'last_page'=>$extraclases->lastPage(),
            'from'=>$extraclases->firstItem(),
            'to'=>$extraclases->lastPage()
        ]
        ,'extraclases'=>$extraclases
    ];
   }

   public function store(Request $request){
        if(!$request->ajax()){return redirect("/");}
        DB::beginTransaction();
        try{
            $extraclase=new Extraclase();
            $extraclase->codigo=$request->codigo;
            $extraclase->nombre=$request->nombre;
            $extraclase->descripcion=$request->descripcion;
            $extraclase->estado=1;
            $extraclase->save();
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
            $extraclase=Extraclase::findOrFail($request->id);
            $extraclase->codigo=$request->codigo;
            $extraclase->nombre=$request->nombre;
            $extraclase->descripcion=$request->descripcion;
            $extraclase->estado=1;
            $extraclase->save();
            DB::commit();
        } 
        catch (\Exception $e){
            DB::rollback();
        }
    }
    public function destroy(Request $request){
        $extraclase=Extraclase::findOrFail($request->id);
        $extraclase->estado=0;
        $extraclase->save();
    }

}
