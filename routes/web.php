<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/main', function () {
    if (auth()->user()->tipo=="admin") {
    	return view('contenido.contenido');
    }
    else if(auth()->user()->tipo=="alumno"){
    	$extraclase=\DB::table('extraclase_alumnos')->join('extraclases','extraclases.id','=','extraclase_alumnos.id')->where('idalumno','=',\Auth::User()->id)->first();
    	return view('alumno.extraclase',["extraclase"=>$extraclase]);
    }else{
    	$extraclase=\DB::table('extraclase_maestros')->join('extraclases','extraclases.id','=','extraclase_maestros.id')->where('idmaestro','=',\Auth::User()->id)->first();
    	return view('maestro.extraclase',["extraclase"=>$extraclase]);
    }
})->name('main')->middleware('auth');



Route::group(['middleware' => ['admin','auth']], function () {
    Route::get('/alumno','AlumnoController@index');
	Route::post('/alumno/registrar','AlumnoController@store');
	Route::post('/alumno/registrar','AlumnoController@store');
	Route::put('/alumno/actualizar','AlumnoController@update');
	Route::put('/alumno/eliminar','AlumnoController@destroy');
	Route::post('/alumno/importar','AlumnoController@import');

	Route::get('/maestro','MaestroController@index');
	Route::post('/maestro/registrar','MaestroController@store');
	Route::put('/maestro/actualizar','MaestroController@update');
	Route::put('/maestro/eliminar','MaestroController@destroy');

	Route::get('/extraclase','ExtraclaseController@index');
	Route::post('/extraclase/registrar','ExtraclaseController@store');
	Route::put('/extraclase/actualizar','ExtraclaseController@update');
	Route::put('/extraclase/eliminar','ExtraclaseController@destroy');

	Route::get('/carrera','CarreraController@index');
	Route::post('/carrera/registrar','CarreraController@store');
	Route::put('/carrera/actualizar','CarreraController@update');
	Route::put('/carrera/eliminar','CarreraController@destroy');
	Route::get('/getCarrera','CarreraController@getCarrera');

	Route::get('/grupo','GrupoController@index');
	Route::post('/grupo/registrar','GrupoController@store');
	Route::put('/grupo/actualizar','GrupoController@update');
	Route::put('/grupo/eliminar','GrupoController@destroy');
});

Route::get('/publicaciones','PublicacionController@index');
Route::post('/publicacion/registrar','PublicacionController@store');
Route::post('/publicacion/comentar','PublicacionController@comentar');
Route::get('/comentarios','PublicacionController@getComentarios');


//rutas para el logueo
Route::get('/','Auth\LoginController@showLoginForm');
Route::post('/login','Auth\LoginController@login')->name('login');
Route::post('/logout','Auth\LoginController@logout')->name('logout');