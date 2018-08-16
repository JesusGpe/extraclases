@extends('principal')
@section('contenido')
	<template v-if="menu==1">
		<alumno></alumno>
	</template>
	<template v-if="menu==2">
		<maestro></maestro>
	</template>
	<template v-if="menu==3">
		<extraclase></extraclase>
	</template>
	<template v-if="menu==4">
		<chat></chat>
	</template>
	<template v-if="menu==5">
		<carrera></carrera>
	</template>
	<template v-if="menu==6">
		<grupo></grupo>
	</template>

@endsection