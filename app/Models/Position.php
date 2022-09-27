<?php

namespace App\Models;

use App\Models\InitModel;

class Position extends InitModel
{
    protected $table = 'sg_position';
    
    public function employee()
	{		
		/* main fk -> this pk */
		return $this->belongsTo('App\Models\Employee','position_id','id')->withDefault(['position_name' => '-']);		
    }
}
