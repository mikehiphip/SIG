<?php	
	namespace App\Models;	
	use App\Models\InitModel;
	
	class EswlPrice extends InitModel
	{		
		protected $table = 'nm_hospital_price';				
		public function hospital()
		{
			// return $this->hasOne('App\Models\Backend\Masters\Hospital','id','id_hosp');
			return $this->belongsTo('App\Models\Backend\Masters\Hospital','id_hosp','id');
		}
		public function sheetEswl()
		{			
			// return $this->hasOne('App\Models\Backend\Masters\SheetEswl','id','id_eswl');
			return $this->belongsTo('App\Models\Backend\Masters\SheetEswl','id_eswl','id');
		}
	}
