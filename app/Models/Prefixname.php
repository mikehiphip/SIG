<?php

namespace App\Models;

use App\Models\InitModel;

class Prefixname extends InitModel
{
    protected $table = 'sg_prefixname';
    
    public function employee()
	{	
		/* main fk -> this pk */
		return $this->belongsTo('App\Models\Employee','prefixideng','id')->withDefault(['prefixnameeng' => '-', 'prefixnamethai	' => '-']);	
    }
}
