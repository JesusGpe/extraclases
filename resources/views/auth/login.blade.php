@extends('layouts.app')

@section('content')
<div class="login-box  bg-primary">
  <div class="login-logo">
    <a href="#" style="color: white;"><b>UPVE</b>SGE</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Inicia sesion</p>

    <form action="{{route('login')}}" method="post">
        {{csrf_field()}}
      <div class="form-group has-feedback {!! $errors->has('usuario') ? 'has-error' : ''!!} ">
        <input type="text" class="form-control" placeholder="usuario" name="usuario" value="{{old('usuario')}}">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        {!! $errors->first('usuario','<span class="help-block">:message</span>')!!}
      </div>
      <div class="form-group has-feedback {!! $errors->has('password') ? 'has-error' : ''!!}">
        <input type="password" class="form-control" placeholder="Contraseña" name="password">
        {!! $errors->first('password','<span class="help-block">:message</span>')!!}
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
        </div>
        <!-- /.col -->
        <div class="col-xs-12">
          <button type="submit" class="btn btn-primary btn-block ">Ingresar</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
    <!-- /.social-auth-links -->

    <a href="#">I forgot my password</a><br>
    <a href="register.html" class="text-center">Register a new membership</a>

  </div>
  <!-- /.login-box-body -->
</div>
@endsection
