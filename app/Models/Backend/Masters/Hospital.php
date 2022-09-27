<?php

namespace App\Models\Backend\Masters;

use App\Models\InitModel;

class Hospital extends InitModel
{
    protected $table = 'nm_hospital';

    public function recordEswl()
    {        
        return $this->hasmany('\App\Models\SheetEswlTransaction','treatment_hos_id','id');
    }

    public function recordEndo()
    {        
        return $this->hasmany('\App\Models\SheetEndourologicTransaction','detail_hos_id','id');
    }

    public function recordSurg()
    {        
        return $this->hasmany('\App\Models\SheetSurgicalTransaction','detail_hos_id','id');
    }
}
