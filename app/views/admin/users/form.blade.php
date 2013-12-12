@extends('admin.layout.master')

@section('scripts')

	<script src="{{asset('js/chosen/chosen.jquery.min.js')}}"></script>
	<script>
		jQuery(document).ready(function($) {

			$('#user_type').change(function(event) {
				$('#users-control').chosen();
				if($(this).val() == 2) {
					$('#users-select').css('visibility', 'visible').hide().fadeIn('fast');
				} else {
					$('#users-select').fadeOut('fast').css('visibility', 'hidden');
				}
			});
		});
	</script>

@endsection

@section('content')

	<link rel="stylesheet" href="{{asset('js/chosen/chosen.min.css')}}">

	{{Form::open( array('url' => '/admin/users/'.$action, 'method' => 'POST', 'role' => 'form', 'class' => 'form-horizontal' ) )}}
		{{Form::hidden('id', $user->id)}}
	<fieldset>
		<legend>Nuevo Usuario</legend>

		<div class="form-group {{($errors->has('name') ? 'has-error' : '')}} ">
			<label for="" class="col-sm-2 control-label">Nombre</label>
			<div class="col-sm-6">
				{{Form::text('name', Input::old('name') ? Input::old('name') : $user->name, array('class' => 'form-control') )}}
				@if($errors->has('name'))
				<span class="help-block">{{$errors->first('name')}}</span>
				@endif
			</div>
		</div>

		<div class="form-group {{($errors->has('patern_name') ? 'has-error' : '')}} ">
			<label for="" class="col-sm-2 control-label">Apellido Paterno</label>
			<div class="col-sm-6">
				{{Form::text('patern_name', Input::old('patern_name') ? Input::old('patern_name') : $user->patern_name, array('class' => 'form-control') )}}
				@if($errors->has('patern_name'))
				<span class="help-block">{{$errors->first('patern_name')}}</span>
				@endif
			</div>
		</div>

		<div class="form-group {{($errors->has('patern_name') ? 'has-error' : '')}} ">
			<label for="" class="col-sm-2 control-label">Apellido Materno</label>
			<div class="col-sm-6">
				{{Form::text('matern_name', Input::old('matern_name') ? Input::old('matern_name') : $user->matern_name, array('class' => 'form-control') )}}
				@if($errors->has('matern_name'))
				<span class="help-block">{{$errors->first('matern_name')}}</span>
				@endif
			</div>
		</div>

		<div class="form-group {{($errors->has('email') ? 'has-error' : '')}} ">
			<label for="" class="col-sm-2 control-label">Correo</label>
			<div class="col-sm-6">
				{{Form::text('email', Input::old('email') ? Input::old('email') : $user->email, array('class' => 'form-control') )}}
				@if($errors->has('email'))
				<span class="help-block">{{$errors->first('email')}}</span>
				@endif
			</div>
		</div>

		<div class="form-group {{($errors->has('password') ? 'has-error' : '')}} ">
			<label for="" class="col-sm-2 control-label">Contraseña</label>
			<div class="col-sm-6">
				{{Form::password('password', array('class' => 'form-control') )}}
				@if($errors->has('password'))
				<span class="help-block">{{$errors->first('password')}}</span>
				@endif
			</div>
		</div>

		<div class="form-group">
			<label for="" class="col-sm-2 control-label">Confirmar contraseña</label>
			<div class="col-sm-6">
				{{Form::password('password_confirmation', array('class' => 'form-control') )}}
			</div>
		</div>
                
		<div class="form-group">
            <label for="" class="col-sm-2 control-label">Tipo de Usuario</label>
            <div class="col-sm-6">
                <select name="user_type" id="user_type" class="form-control">
                    @foreach( $user_type as $u_type )
                        <option value="{{$u_type->id}}" @if($user->user_type == $u_type->id) selected='selected' @endif >{{$u_type->description}}</option>
                    @endforeach
                </select>
            </div>
		</div>

		<div id="users-select" class="form-group" style="visibility:hidden">
			<label for="" class="col-sm-2 control-label">Nombre Supervisor</label>
			<div class="col-sm-6">
				<select name="user_id" class="form-control" id="users-control">
					@foreach($users as $user)
					<option value="{{$user->id}}">{{$user->name.' '.$user->patern_name.' '.$user->matern_name}}</option>
					@endforeach
				</select>
			</div>
		</div>

		{{Form::submit('Guardar', array('class' => 'btn btn-default'))}}


	</fieldset>

	{{Form::close()}}

@endsection