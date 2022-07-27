<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
	protected $table = 'topics';
	protected $primaryKey = 'id';
	public $timestamps = true;

    public function subject(){
    	return $this->belongsTo('App\Models\Subject');
    }

    public function topicsTaken(){
    	return $this->hasMany('App\Models\Topics_taken');
    }
}
