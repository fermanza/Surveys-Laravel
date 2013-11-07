<?php
class QuestionaryMadeAnswers extends Eloquent
{

	protected $table = 'questionary_made_answers';
	public $timestamps = false;

	public function questionaryMade()
	{
		return $this->belongsTo('QuestionaryMade');
	}

	public function answer()
	{
		return $this->belongsTo('Answer');
	}

	public function question()
	{
		return $this->belongsTo('Question');
	}

}