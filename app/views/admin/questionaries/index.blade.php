@extends('admin.layout.master')

@section('content')

	<!--{{link_to('/admin/surveys/create', 'Agregar', array('class' => 'btn btn-primary pull-right'))}}-->
	<div class="clearfix"></div>

	<table class="table">
		<thead>
			<th>ID</th>
			<th>Nombre del Cuestionario</th>
			<th></th>
		</thead>
		<tbody>
			@foreach($questionaries as $questionary)
			<tr>
				<td>{{$questionary->id}}</td>
				<td>{{$questionary->name}}</td>
				<td>
                                    {{link_to('/admin/surveys/'.$questionary->id, 'Ver', array('class' => 'btn btn-info'))}}
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>

@endsection