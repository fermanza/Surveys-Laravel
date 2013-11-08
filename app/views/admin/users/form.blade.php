@extends('admin.layout.master')

@section('content')

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
                        <select name="user_type" id="user_type">
                                @foreach( UserType::where( $user_type as $u_type )
				{{Form::select('user_type', $user_type, $user->user_type) }}
                                    <!--<option value="{{$u_type->id}}" {{ ($u_type->id == Session::get('app-id')) ? 'selected="selected"' : '' }} >{{$u_type->description}}</option>-->
                                    <option value="{{$u_type->id}}">{{$u_type->description}}</option>
                                @endforeach
                        </select>
			</div>
                        
                        <select name="app_id" id="app_id">
                                @foreach( AppModel::where( 'id_company', '=', Auth::user()->company->id )->get() as $app )
                                <option value="{{$app->id}}" {{ ($app->id == Session::get('app-id')) ? 'selected="selected"' : '' }} >{{$app->name_app}}</option>
                                @endforeach
                        </select>
		</div>

		{{Form::submit('Guardar', array('class' => 'btn btn-default'))}}


	</fieldset>

	{{Form::close()}}

@endsection