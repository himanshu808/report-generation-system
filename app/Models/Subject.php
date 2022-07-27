<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
	protected $table = 'subjects';
	protected $primaryKey = 'id';
	public $timestamps = true;

    public function user(){
    	return $this->belongsTo('App\User');
    }

    public function classes(){
    	return $this->belongsTo('App\Models\Classes');
    }

    public function topics(){
    	return $this->hasMany('App\Models\Topic');
    }

     public function months(){
        return $this->belongsToMany('App\Models\Month')->withPivot('lectures_planned','practicals_planned')->withTimestamps();
    }

    public function lectures(){
        return $this->hasMany('App\Models\Lecture');
    }
}
