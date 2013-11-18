<?php
class Question extends Eloquent
{
        protected $table = 'questions';
	public $timestamps = false;

	public function answers()
	{
		return $this->hasMany('Answer');
	}
}