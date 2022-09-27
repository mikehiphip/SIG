<?php
	
	namespace App\Models;
	
	use App\Models\InitModel;
	
	class Logs extends InitModel
	{
		public $timestamps = false;
		
		protected $table = 'ck_log';
		
	}
