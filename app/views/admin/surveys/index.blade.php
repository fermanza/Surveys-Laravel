@extends('admin.layout.master')

@section('content')

	{{link_to('/admin/surveys/new_survey/'.$id_questionary, 'Capturar Encuesta', array('class' => 'btn btn-primary pull-right'))}}
	<div class="clearfix"></div>

	<table class="table">
		<thead>
			<th>N&uacute;mero</th>
			<th>Pregunta</th>
			<th></th>
		</thead>
		<tbody>
                        <?php $i = 1; ?>
			@foreach($questions as $question)
			<tr>
				<td>{{ $i }}</td>
				<td>{{$question->question}}</td>
			</tr>
                        <?php $i++ ?>
			@endforeach
		</tbody>
	</table>

@endsection