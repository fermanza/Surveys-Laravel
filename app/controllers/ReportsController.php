<?php
class ReportsController extends BaseController
{

	public function users_surveys()
	{
		return View::make('admin.reports.users_surveys')
			->with('section', 'Encuestas por capturista')
			->with('users', QuestionaryMade::getQuestionariesByUser(0, Input::get('start_date'), Input::get('end_date')));
	}

	public function pollster_surveys()
	{
		return View::make('admin.reports.pollster_surveys')
			->with('section', 'Encuestas por encuestador')
			->with('users', QuestionaryMade::getQuestionariesByUser(1, Input::get('start_date'), Input::get('end_date')));
	}

}