@extends('admin.layout.master')

@section('content')

	{{link_to('/admin/surveys/create', 'Agregar', array('class' => 'btn btn-primary pull-right'))}}
	<div class="clearfix"></div>

	<table class="table">
		<thead>
			<th>ID</th>
			<th>Nombre del Cuestionario</th>
			<!--<th>Meta</th>-->
			<th></th>
		</thead>
		<tbody>
			@foreach($questionaries as $questionary)
			<tr>
				<td>{{$questionary->id}}</td>
				<td>{{$questionary->name}}</td>
				<!--<td>{{$questionary->goal}}</td>-->
				<td>
                                    {{link_to('/admin/surveys/'.$questionary->id, 'Ver', array('class' => 'btn btn-info'))}}
                                    {{link_to('/admin/surveys/view-surveys/'.$questionary->id, 'Ver Encuestas', array('class' => 'btn btn-primary'))}}
<!--                                    {{link_to('/admin/surveys/delete/'.$questionary->id, 'Eliminar', array('class' => 'btn btn-danger'))}}-->
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>

@endsection