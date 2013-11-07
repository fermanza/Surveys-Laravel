@extends('admin.layout.master')

@section('content')

	{{link_to('/admin/users/create', 'Agregar', array('class' => 'btn btn-primary pull-right'))}}
	<div class="clearfix"></div>

	<table class="table">
		<thead>
			<th>ID</th>
			<th>Nombre</th>
			<th>Apellido Paterno</th>
			<th>Apellido Materno</th>
			<th></th>
		</thead>
		<tbody>
			@foreach($users as $user)
			<tr>
				<td>{{$user->id}}</td>
				<td>{{$user->name}}</td>
				<td>{{$user->patern_name}}</td>
				<td>{{$user->matern_name}}</td>
				<td>
					{{link_to('/admin/users/details/'.$user->id, 'Ver', array('class' => 'btn btn-info'))}}
					{{link_to('/admin/users/update/'.$user->id, 'Modificar', array('class' => 'btn btn-primary'))}}
					{{link_to('/admin/users/delete/'.$user->id, 'Eliminar', array('class' => 'btn btn-danger'))}}
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>

@endsection