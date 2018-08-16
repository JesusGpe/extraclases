@extends('principal')
	@section('contenido')
	@if($extraclase)
	<publicacion :idextraclase="{{$extraclase->id}}"></publicacion>
	<publicaciones :idextraclase="{{$extraclase->id}}" :authid="{{auth()->user()->id}}"></publicaciones>	
	@else
		<h3>Aun no estas en ninguna clase contacte al administraor para que le asigne la clase correspondiente</h3>
	@endif
	@endsection