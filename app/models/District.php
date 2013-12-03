<?php
class District extends Eloquent
{
    protected $table = 'district';
	public $timestamps = false;

	public function state()
	{
		return $this->belongsTo('District');
	}

	public function townships()
	{
		return $this->hasMany('Township');
	}
}