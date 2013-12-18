<!DOCTYPE html>
<html>
	<head>
		<title>Encuestas | {{$section}}</title>
		<meta charset="UTF-8" />
		<link rel="stylesheet" href="{{asset('css/ui-lightness/jquery-ui-1.10.3.custom.min.css')}}">
		<link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
		<link rel="stylesheet" href="{{asset('css/default.css')}}">
	</head>
	<body>
		<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
  			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
			    </button>
			    <a class="navbar-brand" href="#">
			    	<img src="{{asset('img/logo.png')}}" alt="" style="margin: -15px">
			    </a>
			    <a class="navbar-brand" href="#">
			    	Sistema Encuestas | {{$section}}
			    </a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li>
                                            <?php if(Auth::user()->user_type==1){ ?>
						{{link_to('admin/users', 'Usuarios')}}
                                            <?php } ?>
					</li>
					<li>
                                            <?php if(Auth::user()->user_type==1 || Auth::user()->user_type==3){ ?>
						{{link_to('admin/projects', 'Proyectos')}}
                                            <?php } ?>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Reportes <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li>{{link_to('admin/reports/users-surveys', 'Encuestas por capturista')}}</li>
							<li>{{link_to('admin/reports/pollster-surveys', 'Encuestas por encuestador')}}</li>
						</ul>
					</li>
					
			    </ul>
				<!-- <form class="navbar-form navbar-left" role="search">
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Search">
					</div>
					<button type="submit" class="btn btn-default">Submit</button>
				</form> -->
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							{{Auth::user()->name.' '.Auth::user()->patern_name.' '.Auth::user()->matern_name}}
							<b class="caret"></b>
						</a>
						<ul class="dropdown-menu">
							<li>
								{{link_to('/admin/profile', 'Editar Perfil')}}
							</li>
							<li class="divider"></li>
							<li>
								{{link_to('/admin/login/logout', 'Cerrar Sesión')}}
							</li>
						</ul>
					</li>
				</ul>
			</div>
		</nav>

		<div class="container">
			@if(Session::has('message'))
			<?php $message_type = Session::get('message'); ?>
				<div class="alert alert-{{$message_type['type']}} alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					{{$message_type['message']}}
				</div>
			@endif

			<div id="validation-error" class="alert alert-danger alert-dismissable" style="display:none">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				Revise los campos en rojo antes de continuar
			</div>
			
			@yield('content')
		</div>

		<script src="{{asset('js/jquery.js')}}"></script>
		<script src="{{asset('js/jquery-ui-1.10.3.custom.min.js')}}"></script>
		<script src="{{asset('js/bootstrap.min.js')}}"></script>
		<script>
			jQuery(document).ready(function($) {
				$('.input-date').datepicker({ dateFormat: 'yy-mm-dd' });
			});
		</script>
		@yield('scripts')
	</body>
</html>