<?php
class Questionary extends Eloquent 
{

	protected $table = 'questionary';
	public $timestamps = false;

	public function questions()
	{
		return $this->hasMany('Question');
	}

}