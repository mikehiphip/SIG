<?php
	
	namespace App\Models\Backend\Masters;
	
	use App\Models\InitModel;
	
	class Machine extends InitModel
	{
		protected $table = 'nm_machine';	
		
		public function machineType()
		{
			return $this->belongsTo('App\Models\Backend\Masters\MachineType','machinetypeid','id');
		}
		
	}
