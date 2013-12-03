<?php
class State extends Eloquent
{
    protected $table = 'state';
	public $timestamps = false;

	public function country()
	{
		return $this->belongsTo('Country');
	}

	public function districts()
	{
		return $this->hasMany('District');
	}
}