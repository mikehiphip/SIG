<?php

namespace App\Models;

use App\Models\InitModel;

class ReceiveEmail extends InitModel
{
    protected $table = 'sg_receive_email';
    
    // public function employee()
	// {		
		// return $this->belongsTo('App\Models\Train','id_emp','id')->withDefault(['name' => '-']);
		// return $this->belongsTo('App\Models\Train','id_emp','id');
    // }  
}
