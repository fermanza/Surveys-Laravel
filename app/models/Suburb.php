<?php
class Suburb extends Eloquent
{
    protected $table = 'suburb';
	public $timestamps = false;

	public function township()
	{
		return $this->hasMany('Suburb');
	}
}