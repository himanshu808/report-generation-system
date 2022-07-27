<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
	protected $table = 'classes';
	protected $primaryKey = 'id';
	// public $timestamps = false;
	public $timestamps = true;
	
    public function subjects(){
    	return $this->hasMany('App\Models\Subject');
    }
}
