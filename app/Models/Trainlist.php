<?php

namespace App\Models;

use App\Models\InitModel;

class Trainlist extends InitModel
{
    protected $table = 'sg_train_list';    
     
	public function trainEmp()
	{
		/* this fk -> main pk */
		return $this->hasmany('App\Models\TrainEmp','id_train','id')->withDefault(['id_train' => '-']);
    }
}
