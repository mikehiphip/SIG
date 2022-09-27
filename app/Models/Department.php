<?php

namespace App\Models;

use App\Models\InitModel;

class Department extends InitModel
{
    protected $table = 'sg_department';
    
    public function employee()
	{		
		/* main fk -> this pk */
		return $this->belongsTo('App\Models\Employee','department_id','id')->withDefault(['department_name' => '-']);		
    }  
}
