@extends('admin.layout.master')

@section('content')

	{{Form::open( array('url' => '/admin/users/delete', 'method' => 'POST', 'role' => 'form', 'class' => 'form-horizontal' ) )}}
		{{Form::hidden('id', $user->id)}}
	<fieldset>
		<legend>Eliminar Usuario</legend>

		<div class="form-group">
			<label for="" class="col-sm-2 control-label">Nombre</label>
			<div class="col-sm-10">
				{{Form::text('name', Input::old('name') ? Input::old('name') : $user->name, array('class' => 'form-control', 'disabled') )}}
			</div>
		</div>

		<div class="form-group">
			<label for="" class="col-sm-2 control-label">Apellido Paterno</label>
			<div class="col-sm-10">
				{{Form::text('patern_name', Input::old('patern_name') ? Input::old('patern_name') : $user->patern_name, array('class' => 'form-control', 'disabled') )}}
			</div>
		</div>

		<div class="form-group">
			<label for="" class="col-sm-2 control-label">Apellido Materno</label>
			<div class="col-sm-10">
				{{Form::text('matern_name', Input::old('matern_name') ? Input::old('matern_name') : $user->matern_name, array('class' => 'form-control', 'disabled') )}}
			</div>
		</div>

		<div class="form-group">
			<label for="" class="col-sm-2 control-label">Correo</label>
			<div class="col-sm-10">
				{{Form::text('email', Input::old('email') ? Input::old('email') : $user->email, array('class' => 'form-control', 'disabled') )}}
			</div>
		</div>

	</fieldset>

	<h3>¿Estás seguro de eliminar a este usuario?</h3>
	<p>Esta opción no se puede deshacer</p>

	{{Form::submit('Eliminar', array('class' => 'btn btn-danger'))}}

	{{Form::close()}}

@endsection