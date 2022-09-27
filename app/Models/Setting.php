<?php

namespace App\Models;

use App\Models\InitModel;

class Setting extends InitModel
{
    protected $table = 'sg_setting';
    
    // public function employee()
	// {		
		// return $this->belongsTo('App\Models\Train','id_emp','id')->withDefault(['name' => '-']);
		// return $this->belongsTo('App\Models\Train','id_emp','id');
    // }  
}
