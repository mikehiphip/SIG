<?php
	
	namespace App\Models\Backend\Masters;
	
	use App\Models\InitModel;
	
	class Patient extends InitModel
	{
		protected $table = 'nm_patient';	
		
		public function hospital()
		{		
			return $this->belongsTo('App\Models\Backend\Masters\Hospital','id_hosp','id')->withDefault(['name' => '-']);
		}
		public function sex()
		{			
			return $this->belongsTo('App\Models\Backend\Masters\PatientSex','id_sex','id')->withDefault(['name' => '-']);
		}
		
	}
