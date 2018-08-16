<?php

namespace App\Http\Controllers;

use App\Events\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Image;
use App\Publicacion;
use App\Comentario;
use App\User;
use Carbon\Carbon;
use DB;
use Storage;
class PublicacionController extends Controller
{
    public function index(Request $request){
    	$publicaciones=DB::table('publicaciones')->join('personas','personas.id','=','publicaciones.idpersona')
    	->select('publicaciones.id','publicaciones.idextraclase','personas.nombre','publicaciones.publicacion','publicaciones.imagen','publicaciones.created_at')
    	->where('publicaciones.idextraclase','=',$request->idextraclase)
    	->orderBy('publicaciones.id','desc')
    	->get();

    	return ["publicaciones"=>$publicaciones];
    }

    public function store(Request $request){
        $caracteres = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
        $cadena = "";
        for($i=0;$i<10;$i++)
        {
            $cadena .= substr($caracteres,rand(0,strlen($caracteres)),1);
        }

    	$publicacion = new Publicacion();
    	$publicacion->idextraclase=$request->idextraclase;
    	$publicacion->idpersona=\Auth::User()->id;
    	$publicacion->publicacion=$request->publicacion;

        if($request->hasFile('imagen')){
            $archivo = $request->file('imagen');
            $extension=$archivo->getClientOriginalExtension();
            $nombre=\Auth::User()->id."_".$cadena.".".$extension;
            $archivo->move(public_path().'/archivos/extraclases/',$nombre);
            $publicacion->imagen=$nombre;
        }
        
        $publicacion->estado=1;

    	$publicacion->save();

        $user=User::findOrFail(\Auth::User()->id);
        $mensaje="ha publicado";
        event(new Notification($user,$request->idextraclase,$mensaje));

    	return "Registrada";


    }
    public function comentar(Request $request){
        $comentario=new Comentario();
        $comentario->idpersona=\Auth::User()->id;
        $comentario->idpublicacion=$request->idpublicacion;
        $comentario->comentario=$request->comentario;
        $comentario->save();
    }

    public function getComentarios(Request $request){

        $comentarios=DB::table('comentarios')
        ->join('personas','comentarios.idpersona','=','personas.id')
        ->select('personas.nombre','comentarios.id','comentarios.idpersona','comentarios.idpublicacion','comentarios.comentario','comentarios.created_at')
        ->where('idpublicacion','=',$request->idpublicacion)
        ->orderBy('comentarios.id','desc')
        ->get();

        return ["comentarios"=>$comentarios];
    }	
}
