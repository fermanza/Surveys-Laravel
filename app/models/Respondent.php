<?php
class Respondent extends Eloquent
{
	protected $table = 'respondents';
	public $timestamps = false;

	public function questionaryMade()
	{
		return $this->hasOne('QuestionaryMade');
	}

	
}