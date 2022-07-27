<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Month extends Model
{
    protected $table = 'months';
	protected $primaryKey = 'id';
	public $timestamps = true;

	public function subjects(){
		return $this->belongsToMany('App\Models\Subject');
	}
}
