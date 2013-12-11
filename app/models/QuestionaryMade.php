<?php
class QuestionaryMade extends Eloquent
{
	protected $table = 'questionary_made';
	public $timestamps = false;

	public function user()
	{
		return $this->belongsTo('User');
	}

	public function questionary()
	{
		return $this->belongsTo('Questionary');
	}

	public function respondent()
	{
		return $this->belongsTo('Respondent');
	}

	public function answers()
	{
		return $this->hasMany('QuestionaryMadeAnswers');
	}

	public function country()
	{
		return $this->belongsTo('Country');
	}

	public function state()
	{
		return $this->belongsTo('State');
	}

	public function district()
	{
		return $this->belongsTo('District');
	}

	public function township()
	{
		return $this->belongsTo('Township');
	}

	public function suburb()
	{
		return $this->belongsTo('Suburb');
	}
}