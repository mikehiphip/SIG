<?php

namespace App\Models;

use App\Models\InitModel;

class Employee extends InitModel
{
    protected $table = 'sg_employee';
    
    public function department()
	{		
		/* main fk -> this pk */
		return $this->hasmany('App\Models\Department','department_id','id')->withDefault(['department_name' => '-']);		
    }
	
	public function position()
	{		
		/* main fk -> this pk */
		return $this->hasmany('App\Models\Position','position_id','id')->withDefault(['position_name' => '-']);		
    }
	
	public function prefixname()
	{	
		/* main fk -> this pk */
		return $this->hasmany('App\Models\Prefixname','prefixideng','id')->withDefault(['prefixnameeng' => '-', 'prefixnamethai	' => '-']);	
    }
}
