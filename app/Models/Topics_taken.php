<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Topics_taken extends Model
{
	protected $table = "topics_taken";
	protected $primaryKey = 'id';
	public $timestamps = true;
	
    public function lecture(){
    	return $this->belongsTo('App\Models\Lecture');
    }

    public function topic(){
    	return $this->belongsTo('App\Models\Topic');
    }
}
