<!DOCTYPE >
<html>
	<head>
		<title>VSEncuestas | Iniciar Sesión</title>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
		<style type="text/css">
	      body {
	        padding-top: 40px;
	        padding-bottom: 40px;
	        background-color: #f5f5f5;
	      }

	      .form-signin {
	        max-width: 410px;
	        padding: 19px 29px 29px;
	        margin: 0 auto 20px;
	        background-color: #fff;
	        border: 1px solid #e5e5e5;
	        text-align: center;
	        -webkit-border-radius: 5px;
	           -moz-border-radius: 5px;
	                border-radius: 5px;
	        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
	           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
	                box-shadow: 0 1px 2px rgba(0,0,0,.05);
	      }
	      .form-signin .form-signin-heading,
	      .form-signin .checkbox {
	        margin-bottom: 10px;
	      }
	      .form-signin input[type="text"],
	      .form-signin input[type="password"] {
	        font-size: 16px;
	        height: auto;
	        margin-bottom: 15px;
	        padding: 7px 9px;
	      }

	    </style>
	</head>
	<body>
		<div class="container">
			{{Form::open(array( 'url' => 'admin/logon', 'method' => 'POST', 'class' => 'form-signin'))}}
			<div class="text-center">
				<img src="{{asset('img/login-logo.png')}}" alt="">				
			</div>
			<div>
				<h2 class="form-signin-heading">Inicia Sesión</h2>				
			</div>
			<div>
				<input type="text" name="email" class="input-block-level form-control" placeholder="Email...">				
			</div>
			<div>
				<input type="password" name="password" class="input-block-level form-control" placeholder="Password...">				
			</div>
			<button class="btn btn-large btn-primary" type="submit">Iniciar Sesión</button>
			{{Form::close()}}
		</div>
	</body>
</html>