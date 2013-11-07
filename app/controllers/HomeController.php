<?php

class HomeController extends BaseController {


	public function index()
	{
		return View::make('admin.home.index')
			->with('section', 'Inicio');
	}

}