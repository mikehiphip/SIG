<?php
	
	namespace App\Http\Controllers\Backend\Masters;
	
	use Illuminate\Http\Request;
	use App\Http\Controllers\Controller;
	use DB;
	
	class PatientController extends Controller 
	{
		public function index(Request $request)
		{			
			return view('backend.masters.patient.index');
		}
		
		public function create()
		{		
			$sHospital 		= \App\Models\Backend\Masters\Hospital::orderBy('name', 'asc')->get();
			$sPatientSex 	= \App\Models\Backend\Masters\PatientSex::orderBy('id', 'asc')->get();
			
			$sTechnician 	= \App\Models\Backend\Masters\Technician::orderBy('id', 'asc')->get();
			
			$sPhysician 	= \App\Models\Backend\Masters\Physician::orderBy('id', 'asc')->get();
			$sTreatmentSheet 	= \App\Models\Backend\Masters\TreatmentSheet::orderBy('id', 'asc')->get();			
			$sAssistance 	= \App\Models\Backend\Masters\Assistance::orderBy('id', 'asc')->get();
			
			$sTreatment_sheet 			= array();
			$sRadiographer 				= array();
			$sAssistant_radiographers 	= array();
			
			return view('backend.masters.patient.form')->with(
				[
					'sHospital'		=> $sHospital, 
					'sPatientSex'	=> $sPatientSex,
					'sTreatmentSheet'	=> $sTreatmentSheet,
					'sPhysician'	=> $sPhysician,
					'sTechnician'	=> $sTechnician,
					'sAssistance'	=> $sAssistance,	
					'sTreatment_sheet'			=> $sTreatment_sheet,
					'sRadiographer'				=> $sRadiographer,
					'sAssistant_radiographers'	=> $sAssistant_radiographers,
				]
			);
		}
		
		public function store(Request $request)
		{
			// dd($request);
			return $this->form();
		}
		
		public function update(Request $request, $id)
		{			
			// dd($request);
			return $this->form($id);
		}
		
		public function form($id=NULL)
		{
			\DB::beginTransaction();
			try {
				if( $id ){
					$sRow = \App\Models\Backend\Masters\Patient::find($id);
				}else{
					$sqlcheck   = "
						select id from nm_patient 
						where name_first='".request('name_first')."' 
						and name_last='".request('name_last')."'
						and id_hosp='".request('id_hosp')."'
					";
					$rowcheck 	= DB::select($sqlcheck);
					if($rowcheck){																
						return redirect()->action('Backend\Masters\PatientController@index')->with(['alert'=>\App\Models\Alert::MsgData('error', 'ไม่สามารถบันทึกข้อมูลได้ เนื่องจากข้อมูลนี้ มีข้อมูลอยู่ในระบบแล้ว')]);
					}else{
						$sRow = new \App\Models\Backend\Masters\Patient;
						$sqlgen   	= "select max(code) as idmax from nm_patient where code<>''";
						$rowgen 	= DB::select($sqlgen);
						$rowgen		= $rowgen[0];
						$v_idmax	= substr($rowgen->idmax, 1); 
						// dd($v_idmax);
						$v_idmax	= intval($v_idmax)+1;
						$sRow->code		= 'P'.str_pad($v_idmax,4,"0",STR_PAD_LEFT);
					}					
				}
				$sRow->id_hosp    		= request('id_hosp');
				$sqlhosp   	= "select name from nm_hospital where id ='".request('id_hosp')."'";
				// echo $sqlhosp; exit();
				$rowhosp 	= DB::select($sqlhosp);
				$sRow->name_hosp		= $rowhosp[0]->name;
				
				$sRow->name_pre    		= request('name_pre');
				$sRow->name_first    	= request('name_first');
				$sRow->name_last    	= request('name_last');
				$sRow->name_full    	= request('name_pre').' '.request('name_first').' '.request('name_last');
				
				$sRow->number_id  		= request('number_id');
				$sRow->hn_no  			= request('hn_no');														
				$sRow->id_sex  			= request('id_sex');										
				$sRow->birthday  		= date_format(date_create(request('birthday')), "Y-m-d");										
				$sRow->age  			= request('age');										
				$sRow->book_number3  	= request('book_number3') ?? null;										
				$sRow->book_number5  	= request('book_number5') ?? null;
				$sRow->book_number3_endo  	= request('book_number3_endo') ?? null;
				$sRow->book_number4_endo  	= request('book_number4_endo') ?? null;
				$sRow->book_number3_surg  	= request('book_number3_surg') ?? null;
				$sRow->book_number4_surg  	= request('book_number4_surg') ?? null;
				
				// dd(request('treatment_sheet'));
				$treatment_sheet = "";
				if(request('treatment_sheet')){
					foreach(request('treatment_sheet') as $k => $v){
						if($k=='0'){
							$treatment_sheet = $v;
						}else{
							$treatment_sheet .= ",".$v;
						}
					}				
					$sRow->treatment_sheet		= $treatment_sheet;	
				}else{
					$sRow->treatment_sheet	= "";	
				}

				// $sRow->active    			= request('active')?request('active'):'N';				
				
				// if( request('locale_id') ){
					// $sRow->locale_id    = request('locale_id');
					// }else{
					// $sRow->locale_id    = \Auth::user()->locale_id;
				// }

				$sRow->birthday			= ($sRow->birthday==date("Y-m-d")) ? null : $sRow->birthday;
				// dd($sRow);
				$sRow->save();
				\DB::commit();
				
				return redirect()->action('Backend\Masters\PatientController@index')->with(['alert'=>\App\Models\Alert::Msg('success')]);
			} catch (\Exception $e) {
				echo $e->getMessage();
				\DB::rollback();
				return redirect()->action('Backend\Masters\PatientController@index')->with(['alert'=>\App\Models\Alert::e($e)]);
			}
		}
		
		
		public function edit($id)
		{
			try {				
				$sRow = \App\Models\Backend\Masters\Patient::find($id);
				
				$sHospital 		= \App\Models\Backend\Masters\Hospital::orderBy('name', 'asc')->get();
				$sPatientSex 	= \App\Models\Backend\Masters\PatientSex::orderBy('id', 'asc')->get();
				
				$sTreatmentSheet 	= \App\Models\Backend\Masters\TreatmentSheet::orderBy('id', 'asc')->get();			
				
				$sPhysician 	= \App\Models\Backend\Masters\Physician::orderBy('id', 'asc')->get();			
				$sTechnician 	= \App\Models\Backend\Masters\Technician::orderBy('id', 'asc')->get();
				$sAssistance 	= \App\Models\Backend\Masters\Assistance::orderBy('id', 'asc')->get();
				
				$sTreatment_sheet 			= explode(",",$sRow->treatment_sheet);
				$sRadiographer 				= explode(",",$sRow->radiographer);
				$sAssistant_radiographers 	= explode(",",$sRow->assistant_radiographers);
				
				return view('backend.masters.patient.form')->with(
					[
						'sRow'				=> $sRow, 
						'sHospital'			=> $sHospital, 
						'sPatientSex'		=> $sPatientSex,
						'sTreatmentSheet'	=> $sTreatmentSheet,
						'sPhysician'		=> $sPhysician,
						'sTechnician'		=> $sTechnician,
						'sAssistance'		=> $sAssistance,					
						'sAssistance'		=> $sAssistance,					
						'sTreatment_sheet'			=> $sTreatment_sheet,
						'sRadiographer'				=> $sRadiographer,
						'sAssistant_radiographers'	=> $sAssistant_radiographers,
					]
				);
				// return View('backend.masters.machine.form')->with(array('sRow'=>$sRow) );
			} catch (\Exception $e) {
				return redirect()->action('Backend\Masters\PatientController@index')->with(['alert'=>\App\Models\Alert::e($e)]);
			}
		}
		
		
		public function destroy($id)
		{
			$sRow = \App\Models\Backend\Masters\Patient::find($id);
			if( $sRow ){
				// $sRow->forceDelete(); // ลบจริง
				$sRow->delete();
			}
			return response()->json(\App\Models\Alert::Msg('success'));
		}
		
		public function Datatable(){
			$sTable = \App\Models\Backend\Masters\Patient::search()->orderBy('code', 'desc');
			/* For Debug
			// $sTable = $sTable->with('machineType');
			// dd($sTable->get());		
			*/
			
			$sQuery = \DataTables::of($sTable);
			return $sQuery
			->addColumn('hospitalname', function($row) {
				return $row->hospital->name;				
			})			
			->addColumn('names', function($row) {
				return is_null($row->names) ? '-' : $row->names;
			})
			->addColumn('number_id', function($row) {
				return is_null($row->number_id) ? '-' : $row->number_id;
			})
			->addColumn('hn_no', function($row) {
				return is_null($row->hn_no) ? '-' : $row->hn_no;
			})
			->addColumn('treatment_sheet', function($row) {
				if(!is_null($row->treatment_sheet) and $row->treatment_sheet != ''){
					$datas_arr 	= explode(",",$row->treatment_sheet);
					$datas		= "<br>";
					foreach($datas_arr as $k => $v){
						if($k==0){
							$datas .= ($k+1)."). ".$v;
						}else{
							$datas .= "<br>".($k+1)."). ".$v;
						}					
					}
				}else{
					$datas = "-";
				}
				return $datas;
			})
			->addColumn('sexname', function($row) {
				return $row->sex->name;				
			})
			->addColumn('birthday', function($row) {
				return is_null($row->birthday) ? '-' : date_format(date_create($row->birthday), 'd-m-Y');				
			})
			->addColumn('age', function($row) {
				return is_null($row->age) ? '-' : $row->age;				
			})
			->addColumn('updated_at', function($row) {
				return is_null($row->updated_at) ? '-' : $row->updated_at;
			})
			->addColumn('actions', function($row) {
				$details = "";
				/* object1 */
				$details .= "<a href='";
				$details .= route('backend.masters.patient.index')."/".$row->id."/edit";
				$details .= "'";
				$details .= "class='btn btn-sm btn-primary'> <i class='bx bx-edit font-size-16 align-middle'></i></a>";
				
				$details .= " ";
				
				/* object2 */
				$details .= "<a href='javascript: void(0);'";
				$details .= "data-url='";
				$details .= route('backend.masters.patient.index')."/".$row->id;
				$details .= "'";
				$details .= "class='btn btn-sm btn-danger cDelete'> <i class='bx bx-edit font-size-16 align-middle'></i></a>";
				return $details;
			})
			->escapeColumns('treatment_sheet')
			->make(true);
		}
	}
