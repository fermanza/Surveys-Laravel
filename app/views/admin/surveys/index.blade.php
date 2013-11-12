@extends('admin.layout.master')

@section('content')

	{{link_to('/admin/surveys/create', 'Agregar', array('class' => 'btn btn-primary pull-right'))}}
	<div class="clearfix"></div>

	<table class="table">
		<thead>
			<th>ID</th>
			<th>Nombre de Encuesta</th>
			<th>Meta</th>
			<th></th>
		</thead>
		<tbody>
			@foreach($surveys as $survey)
			<tr>
				<td>{{$survey->id}}</td>
				<td>{{$survey->question}}</td>
				<td>
                                    {{link_to('/admin/surveys/details/'.$survey->id, 'Ver', array('class' => 'btn btn-info'))}}
                                    {{link_to('/admin/surveys/view-surveys/'.$survey->id, 'Ver Encuestas', array('class' => 'btn btn-primary'))}}
<!--                                    {{link_to('/admin/surveys/delete/'.$survey->id, 'Eliminar', array('class' => 'btn btn-danger'))}}-->
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>

@endsection