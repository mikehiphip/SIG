<?php

namespace App\Models;

use App\Models\InitModel;

class Video extends InitModel
{
    protected $table = 'sg_video';
    
    // public function employee()
	// {		
		// return $this->belongsTo('App\Models\Train','id_emp','id')->withDefault(['name' => '-']);
		// return $this->belongsTo('App\Models\Train','id_emp','id');
    // }  
}
