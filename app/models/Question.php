<?php
class Question extends Eloquent
{
	public $timestamps = false;

	public function answers()
	{
		return $this->hasMany('Answer');
	}
}