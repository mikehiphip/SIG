<?php
	
	namespace App\Models\Backend\Masters;
	
	use App\Models\InitModel;
	
	class MachineType extends InitModel
	{
		protected $table = 'nm_machine_type';	
		
		public function machine()
		{
			// return $this->hasmany('App\Models\Backend\Masters\Machine','machinetypeid','id')->where('isActive', 'Y');;
			return $this->hasmany('App\Models\Backend\Masters\Machine','machinetypeid','id');
		}
	}
