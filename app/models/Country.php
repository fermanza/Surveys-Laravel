<?php
class Country extends Eloquent
{
    protected $table = 'country';
	public $timestamps = false;

	public function states()
	{
		return $this->hasMany('State');
	}
}