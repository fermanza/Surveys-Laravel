@extends('admin.layout.master')

@section('content')

	{{link_to('/admin/surveys/new_survey/'.$id_questionary, 'Capturar Encuesta', array('class' => 'btn btn-primary pull-right'))}}
	<div class="clearfix"></div>

	<table class="table">
		<thead>
			<th>N&uacute;mero</th>
			<th>Pregunta</th>
			<!--<th>Opcions</th>-->
			<th></th>
		</thead>
		<tbody>
                        <?php $i = 1; ?>
			@foreach($questions as $question)
			<tr>
				<td>{{ $i }}</td>
				<td>{{$question->question}}</td>
<!--                                <td>{{$question->type}}</td>-->
				<td>
<!--                                    {{link_to('/admin/surveys/details/'.$question->id, 'Ver', array('class' => 'btn btn-info'))}}-->
<!--                                    {{link_to('/admin/surveys/view-surveys/'.$question->id, 'Ver Encuestas', array('class' => 'btn btn-primary'))}}-->
<!--                                    {{link_to('/admin/surveys/delete/'.$question->id, 'Eliminar', array('class' => 'btn btn-danger'))}}-->
				</td>
			</tr>
                        <?php $i++ ?>
			@endforeach
		</tbody>
	</table>

@endsection