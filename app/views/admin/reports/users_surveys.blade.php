@extends('admin.layout.master')

@section('scripts')

	<script>
		jQuery(document).ready(function($) {
			
		});
	</script>

@endsection

@section('content')
	
	<div class="panel panel-default">
		<div class="panel-heading">Filtros</div>
		<div class="panel-body">
			{{Form::open( array( 'url' => 'admin/reports/users-surveys', 'method' => 'POST', 'role' => 'form' ) )}}

			<div class="form-group">
				<label for="" class="col-sm-2">Fecha Inicio</label>
				<div class="col-sm-2">
					{{Form::text('start_date', Input::get('start_date'), array('class' => 'form-control input-date'))}}
				</div>
				<label for="" class="col-sm-2">Fecha Fin</label>
				<div class="col-sm-2">
					{{Form::text('end_date', Input::get('end_date'), array('class' => 'form-control input-date'))}}
				</div>
				<div class="col-sm-1">
					{{Form::submit('Consultar', array('class' => 'btn btn-primary'))}}
				</div>
			</div>
			{{Form::close()}}
		</div>
	</div>

	<div class="panel panel-default">
		<div class="panel-heading">Resultados</div>
		<div class="panel-body">
			<table class="table">
				<thead>
					<th>Capturista</th>
					<th>Encuestas</th>
				</thead>
				<tbody>
					@foreach($users as $user)
					<tr>
						<td>{{$user->userCreate->name.' '.$user->userCreate->patern_name.' '.$user->userCreate->matern_name}}</td>
						<td>{{$user->surveys}}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>

@endsection