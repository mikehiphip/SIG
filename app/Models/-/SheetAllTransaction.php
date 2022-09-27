<?php

namespace App\Models;

use App\Models\InitModel;

class SheetAllTransaction extends InitModel
{
    protected $table = 'nm_sheet_all_transaction';
    
    public function hospital()
	{		
		return $this->belongsTo('App\Models\Backend\Masters\Hospital','detail_hos_id','id')->withDefault(['name' => '-']);
    }
    public function physician()
	{		
		return $this->belongsTo('App\Models\Backend\Masters\Physician','detail_treating_physician','id')->withDefault(['names' => '-']);
	}
}
