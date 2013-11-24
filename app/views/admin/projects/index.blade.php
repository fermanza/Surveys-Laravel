@extends('admin.layout.master')

@section('content')

	<!--{{link_to('/admin/surveys/create', 'Agregar', array('class' => 'btn btn-primary pull-right'))}}-->
	<div class="clearfix"></div>

	<table class="table">
		<thead>
			<th>ID</th>
			<th>Nombre de Encuesta</th>
			<th>Meta</th>
			<th></th>
		</thead>
		<tbody>
			@foreach($projects as $project)
			<tr>
				<td>{{$project->id}}</td>
				<td>{{$project->name}}</td>
				<td>{{ number_format($project->goal) }}</td>
				<td>
                                    {{link_to('/admin/questionaries/'.$project->id, 'Ver Cuestionarios', array('class' => 'btn btn-info'))}}
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>

@endsection