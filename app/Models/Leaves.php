<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Leaves extends Model
{
    protected $table = 'leaves';
	protected $primaryKey = 'id';
	public $timestamps = true;

    public function user(){
    	return $this->belongsTo('App\User');
    }
}
