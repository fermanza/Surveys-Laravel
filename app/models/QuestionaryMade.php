<?php
class QuestionaryMade extends Eloquent
{
	protected $table = 'questionary_made';
	public $timestamps = false;

	public function user()
	{
		return $this->belongsTo('User');
	}

	public function userCreate()
	{
		return $this->belongsTo('User', 'user_create');
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

	public static function getQuestionariesByUser($user_type=0, $start_date, $end_date)
	{

		if($user_type == 1)
		{
			$query = QuestionaryMade::groupBy('user_id')->select(DB::raw('*, count(*) surveys'));

			if($start_date != false && $end_date != false)
			{
				$query->where('date', '>=', $start_date)->where('date', '<=', $end_date);
			}

			return $query->get();

		}
		else 
		{
			$query = QuestionaryMade::groupBy('user_create')->select(DB::raw('*, count(*) surveys'));

			if($start_date != false && $end_date != false)
			{
				$query->where('created_at', '>=', $start_date)->where('created_at', '<=', $end_date);
			}

			return $query->get();
		}

	}
}