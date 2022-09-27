<?php
	
	namespace App\Models;
	
	use App\Models\InitModel;
	
	class DocumentGeneral extends InitModel
	{
		protected $table = 'env_document_general';	
		
		public function document()
		{
			/* main fk -> this pk */
			return $this->belongsTo('App\Models\Backend\Masters\Document','dataspecification_id','id')->withDefault(['names' => null]);;
		}
		
		public function documentGeneralDeatil()
		{
			/* this fk -> main pk */
			return $this->hasmany('App\Models\Backend\DocumentGeneralDetail','doc_general_id','id');
		}
	}
