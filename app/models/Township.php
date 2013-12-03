<?php
class Township extends Eloquent
{
    protected $table = 'township';
	public $timestamps = false;

	public function district()
	{
		return $this->belongsTo('District');
	}

	public function suburbs()
	{
		return $this->hasMany('Suburb');
	}
}