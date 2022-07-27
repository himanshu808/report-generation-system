<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lecture extends Model
{
	protected $table = 'lectures';
	protected $primaryKey = 'id';
	public $timestamps = true;

    public function user(){
    	return $this->belongsTo('App\User');
    }

    public function topicsTaken(){
    	return $this->hasMany('App\Models\Topics_taken');
    }

    public function subject(){
    	return $this->belongsTo('App\Models\Subject');
    }
}
