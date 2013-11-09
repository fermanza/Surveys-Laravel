@extends('admin.layout.master')

@section('content')

	{{Form::open( array('url' => '/admin/users/', 'method' => 'POST', 'role' => 'form', 'class' => 'form-horizontal' ) )}}
		{{Form::hidden('id', $user->id)}}
	<fieldset>
		<legend>Nuevo Usuario</legend>

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
                
		<div class="form-group">
			<label for="" class="col-sm-2 control-label">Tipo de Usuario</label>
			<div class="col-sm-10">
				{{Form::text('user_type', $user_type->description, array('class' => 'form-control', 'disabled') )}}
			</div>
		</div>

	</fieldset>

	{{Form::close()}}

@endsection