<?php

namespace App\Models;

use App\Models\InitModel;

class Station extends InitModel
{
    protected $table = 'sg_station';
    
    public function station()
	{		
		/* main fk -> this pk */
		return $this->belongsTo('App\Models\Station','station_id','id')->withDefault(['station_name' => '-']);		
    }  
}
