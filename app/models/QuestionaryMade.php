<?php
class QuestionaryMade extends Eloquent
{
	protected $table = 'questionary_made';
	public $timestamps = false;

	public function questionary()
	{
		return $this->belongsTo('Questionary');
	}

	public function respondent()
	{
		return $this->belongsTo('Respondent');
	}
}