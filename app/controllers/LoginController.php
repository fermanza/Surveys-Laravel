<?php
	 class LoginController extends BaseController 
	 {

	 	public function index()
	 	{
	 		return View::make('admin.login.index');
	 	}

	 	public function logon()
	 	{

	 		if(Auth::attempt( array('email' => Input::get('email'), 'password' => Input::get('password')) ))
	 		{
	 			return Redirect::to('/admin/home');
	 		}
	 		else
	 		{
	 			return Redirect::to('/admin/login')->with('mensaje', 'Datos incorrectos');
	 		}

	 	}

	 	public function logout()
	 	{
	 		Auth::logout();

	 		return Redirect::to('/');
	 	}

	 }