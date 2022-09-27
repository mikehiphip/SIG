<?php

namespace App\Models;

use App\Models\InitModel;

class TrainEmp extends InitModel
{
    protected $table = 'sg_train_emp';
    
    public function train()
	{
		/* main fk -> this pk */
		return $this->belongsTo('App\Models\Train','id_train','id')->withDefault(['id_train' => '-']);
    }   
}
