<?php
	
	namespace App\Http\Controllers\Backend\Sheet;
	
	use Illuminate\Http\Request;
	use App\Http\Controllers\Controller;
	use Yajra\DataTables\DataTables;
	use DB;
	
	class EndourologicPatientController extends Controller 
	{
		
		public function index(Request $request)
		{
			// return "Test";			
			return view('backend.sheet.endourologic-patient.index');
		}
		
		public function create()
		{		
			// return "Test";
			/* โรงพยาบาล */
			$sHospital 		= \App\Models\Backend\Masters\Hospital::orderBy('name', 'asc')->get();
			/* endourologic */
			// $sSheetEswl 	= \App\Models\Backend\Masters\SheetEswl::orderBy('id', 'asc')->get();			
			/* แพทย์ */
			$sPhysician 	= \App\Models\Backend\Masters\Physician::orderBy('id', 'asc')->get(); 
			/* เครื่องที่ใช้รักษา */
			$sMachine 		= \App\Models\Backend\Masters\Machine::where('machinetypeid', '=', '4')->orderBy('id', 'asc')->get();
			/* ช่างเทคนิก*/
			$sTechnician 	= \App\Models\Backend\Masters\Technician::orderBy('id', 'asc')->get();
			/* ความช่วยเหลือ  */
			$sAssistance 	= \App\Models\Backend\Masters\Assistance::orderBy('id', 'asc')->get();
			/* เพศ */
			$sPatientSex 	= \App\Models\Backend\Masters\PatientSex::orderBy('id', 'asc')->get();
			/* ผู้ป่วย */
			$sPatient 		= \App\Models\Backend\Masters\Patient::orderBy('name_first', 'asc')
							->where('book_number3_endo', '!=', '')
							->where('book_number4_endo', '!=', '')
							->get();
			
			/* เพื่อเลือก หัวข้องาน */
			$sSheetEndourologic 		= \App\Models\Backend\Masters\SheetEndourologic::orderBy('sort', 'asc')->get();
			// dd($sSheetEndourologic);
			
			/* เพื่อเลือก payment */
			$sPayment 					= \App\Models\Backend\Masters\Payment::orderBy('sort', 'asc')->get();
			
			/* เพื่อเลือก fiber size */
			$sFiberSize 				= \App\Models\Backend\Masters\FiberSize::orderBy('id', 'asc')->get();
			
			/* เพื่อเลือก  anesthesia */
			$sAnesthesia 				= \App\Models\Backend\Masters\Anesthesia::orderBy('sort', 'asc')->get();
			
			/* เพื่อเลือก trettment result */
			$sTreatmentResult 			= \App\Models\Backend\Masters\TreatmentResult::orderBy('id', 'asc')->get();
			
			$sSheet_endou 						= array();
			$sDetail_radiographer 				= array();
			$sDetail_assistant_radiographers 	= array();			
			$sDetail_payment 					= array();
			$sDetail_anesthesia 				= array();
			
			$sConclusion_fiber_size 			= array();
			// dd($sPatientSex);
			return view('backend.sheet.endourologic-patient.form')->with(
				[
					'form_status'				=> 'add', 
					'sHospital'					=> $sHospital, 
					// 'sSheetEswl'	=> $sSheetEswl, 
					'sPatientSex'				=> $sPatientSex,
					'sPhysician'				=> $sPhysician,
					'sMachine'					=> $sMachine,
					'sTechnician'				=> $sTechnician,
					'sAssistance'				=> $sAssistance,
					'sPatient'					=> $sPatient,
					'sSheetEndourologic'		=> $sSheetEndourologic,
					'sPayment'					=> $sPayment,
					'sFiberSize'				=> $sFiberSize,
					'sAnesthesia'				=> $sAnesthesia,
					'sTreatmentResult'			=> $sTreatmentResult,
					'sSheet_endou'						=> $sSheet_endou,
					'sDetail_radiographer'				=> $sDetail_radiographer,
					'sDetail_assistant_radiographers'	=> $sDetail_assistant_radiographers,
					'sDetail_payment'			=> $sDetail_payment,
					'sDetail_anesthesia'		=> $sDetail_anesthesia,
					'sConclusion_fiber_size'	=> $sConclusion_fiber_size,
				]
			);
		}
		
		public function store(Request $request)
		{
			// dd($request->all());
			return $this->form();
		}
		
		public function update(Request $request, $id)
		{
			// dd($request->all());
			// dd($request['outer-group']);
			// dd($request['outer-group1']['0']['inner-group1']);			
			// dd($request['outer-group1']['0']['inner-group1']['0']['medical_radiographer']);			
			return $this->form($id);
		}
		
		/* ประวัติผู้ป่วย */
		public function callPatient(Request $request){
			// dd($request->all());
			// dd($request['p_patient_name']);
			
			/* ประวัติผู้ป่วย */						
				$v_patient_id = $request['p_patient_id'];			
				$sqlpatient   	= "
					select 
						name_pre,
						name_first,
						name_last,
						number_id,
						hn_no,
						phone_no,					
						id_sex,
						age,
						birthday,
						book_number3_endo,
						book_number4_endo,
						id_hosp
					from nm_patient np
					where np.id='$v_patient_id'
				";
				// echo $sqlpatient; exit();
				$rowpatient 	= DB::select($sqlpatient);
				// dd($rowpatient);
				$rowpatient		= $rowpatient['0'];
				$r_patient_name			= $rowpatient->name_pre . ' ' . $rowpatient->name_first . ' ' . $rowpatient->name_last;			
				$r_patient_id_number	= $rowpatient->number_id;			
				$r_patient_hn_no		= $rowpatient->hn_no;			
				$r_patient_phone_no		= $rowpatient->phone_no;
				$r_patient_sex_id		= $rowpatient->id_sex;			
				$r_patient_age			= $rowpatient->age;						
				$r_patient_birthday		= $rowpatient->birthday;	
				$r_patient_book_number3	= $rowpatient->book_number3_endo;						
				$r_patient_book_number4	= $rowpatient->book_number4_endo;					
				$r_patient_id_hosp		= $rowpatient->id_hosp;
			/* // ประวัติผู้ป่วย */

			if(isset($r_patient_sex_id)){
				// dd('no null');
				$sqlpatientsex   	= "select name from nm_patient_sex where id='$r_patient_sex_id'";
				// echo $sqlpatient; exit();
				$rowpatientsexarr	= DB::select($sqlpatientsex);
				$r_patient_sex_name	= $rowpatientsexarr[0]->name;				
			}else{
				$r_patient_sex_name	= $r_patient_sex_id;
			}
			
			$datas 		= array(
				"r_status"	=> 'y',
				"r_patient_name"		=> $r_patient_name,
				"r_patient_id_number"	=> $r_patient_id_number,
				"r_patient_hn_no"		=> $r_patient_hn_no,
				"r_patient_phone_no"	=> $r_patient_phone_no,				
				"r_patient_sex_name"	=> $r_patient_sex_name,
				"r_patient_age"			=> $r_patient_age,
				"r_patient_birthday"	=> $r_patient_birthday,
				"r_patient_book_number3"	=> $r_patient_book_number3,
				"r_patient_book_number4"	=> $r_patient_book_number4,
				"r_patient_id_hosp"			=> $r_patient_id_hosp
			);
			// dd($datas);
			return json_encode($datas);			
		}
		
		public function form($id=NULL)
		{
			\DB::beginTransaction();
			try {
				if( $id ){
					/* Main */
					$sRow = \App\Models\SheetEndourologicTransaction::find($id);
					$v_reference_code = $sRow->reference_code;		
					// dd($v_reference_code);

					/* All */
					$sRowAll 	= new \App\Models\SheetAllTransaction;		
					$sRowAll 	= $sRowAll->where('sheettype', 'endo');	
					$sRowAll 	= $sRowAll->where('reference_code', "$v_reference_code");	
					$sRowAll 	= $sRowAll->first();				
					// dd($sRowAll);
				}else{
					$v_book_auto_y = date("Y");
					$v_book_auto_m = date("m");
					$sqlmax 	= "select (MAX(CONVERT(book_auto, SIGNED))+1) as idmax from nm_sheet_endourologic_transaction where book_auto_y='$v_book_auto_y' and book_auto_m='$v_book_auto_m'";					
					$rowmax_arr = DB::select($sqlmax);		
					$rowmax		= ($rowmax_arr['0']->idmax!='') ? str_pad($rowmax_arr['0']->idmax, 5, '0', STR_PAD_LEFT) : '00001';
					
					/* Main */
					$sRow = new \App\Models\SheetEndourologicTransaction;				
					$sRow->book_auto    				= $rowmax;
					$sRow->book_auto_y    				= $v_book_auto_y;
					$sRow->book_auto_m    				= $v_book_auto_m;
					$sRow->reference_code    			= $v_book_auto_y.$v_book_auto_m.$rowmax;
					
					$sRow->patient_id  				= request('patient_id');

					/* All */
					$sRowAll 	= new \App\Models\SheetAllTransaction;
					$sRowAll->book_auto    				= $rowmax;
					$sRowAll->book_auto_y    			= $v_book_auto_y;
					$sRowAll->book_auto_m    			= $v_book_auto_m;
					$sRowAll->reference_code    		= $v_book_auto_y.$v_book_auto_m.$rowmax;
				
					$sRowAll->patient_id  				= request('patient_id');
					$sRowAll->sheettype					= 'endo';
				}		
				
				/* Main */
				$sRow->book_number3    				= request('book_number3_endo');
				$sRow->book_number4    				= request('book_number4_endo');
				$sheet_endou = "";
				foreach(request('sheet_endou') as $k => $v){
					if($k=='0'){
						$sheet_endou = $v;
					}else{
						$sheet_endou .= ",".$v;
					}
				}				
				$sRow->sheet_endou				= $sheet_endou;				
				
				$sRow->detail_hos_id    		= request('detail_hos_id'); 
					
				$sRow->patient_id_number  		= request('patient_id_number');	
				$sRow->patient_name  			= request('patient_name');	
				$sRow->patient_hn_no  			= request('patient_hn_no');		
				$sRow->patient_phone_no  		= request('patient_phone_no');	
				$sRow->patient_age  			= request('patient_age');	
				$sRow->patient_sex_name 		= request('patient_sex_name');	
				$sRow->patient_birthdate		= date_format(date_create(request('patient_birthdate')), "Y-m-d");	
				
				$detail_payment = null;
				if(is_null(request('outer-group1'))){
					$sRow->detail_payment				= $detail_payment;
					$sRowAll->detail_payment			= $detail_payment;				/* All */
				}else{
					foreach(request('outer-group1')['0']['inner-group1'] as $k => $v){
						if($k=='0'){
							$detail_payment = $v['detail_payment'];
						}else{
							$detail_payment .= ",".$v['detail_payment'];
						}
					}				
					$sRow->detail_payment				= $detail_payment;
					$sRowAll->detail_payment			= $detail_payment;				/* All */
				}
				$sRow->detail_payment_other			= request('detail_payment_other');			
				
				$sRow->detail_date    				= date_format(date_create(request('detail_date')), "Y-m-d");
				$sRow->detail_timein  				= request('detail_timein');		
				$sRow->detail_timeout  				= request('detail_timeout');	
				
				$detail_anesthesia = null;
				if(is_null(request('outer-group4'))){
					$sRow->detail_anesthesia			= $detail_anesthesia;
					$sRowAll->detail_anesthesia			= $detail_anesthesia;				/* All */
				}else{
					foreach(request('outer-group4')['0']['inner-group4'] as $k => $v){
						if($k=='0'){
							$detail_anesthesia = $v['detail_anesthesia'];
						}else{
							$detail_anesthesia .= ",".$v['detail_anesthesia'];
						}
					}				
					$sRow->detail_anesthesia			= $detail_anesthesia;
					$sRowAll->detail_anesthesia			= $detail_anesthesia;				/* All */
				}
				$sRow->detail_anesthesia_other		= request('detail_anesthesia_other');
				
				$sRow->detail_anesthesiologist		= request('detail_anesthesiologist');	
				$sRow->detail_treating_physician  	= request('detail_treating_physician');		
				$sRow->detail_machine_types  		= request('detail_machine_types');	

				$detail_radiographer = null;
				if(is_null(request('outer-group2'))){
					$sRow->detail_radiographer			= $detail_radiographer;
					$sRowAll->detail_radiographer		= $detail_radiographer;
				}else{
					/* DashBoard Radiographer Delete */					
					$sRowDashBoardRadiographerDel = \App\Models\SheetEndourologicTransactionRadiographer::where('nm_sheet_endourologic_transaction_id', $id)->forceDelete();

					foreach(request('outer-group2')['0']['inner-group2'] as $k => $v){
						if($k=='0'){
							$detail_radiographer = $v['detail_radiographer'];
						}else{
							$detail_radiographer .= ",".$v['detail_radiographer'];
						}

						/* DashBoard Radiographer Add */
						if($v['detail_radiographer'] != ''){	
							$sRowDashBoardRadiographerAdd = new \App\Models\SheetEndourologicTransactionRadiographer;
							$sRowDashBoardRadiographerAdd->nm_sheet_endourologic_transaction_id	= $id;
							$sRowDashBoardRadiographerAdd->nm_technician_id						= $v['detail_radiographer'];
							$sRowDashBoardRadiographerAdd->save();
						}
					}				
					$sRow->detail_radiographer			= $detail_radiographer;	
					$sRowAll->detail_radiographer		= $detail_radiographer;
				}

				$detail_assistant_radiographers = null;
				if(is_null(request('outer-group3'))){
					$sRow->detail_assistant_radiographers		= $detail_assistant_radiographers;
					$sRowAll->detail_assistant_radiographers	= $detail_assistant_radiographers;
				}else{
					foreach(request('outer-group3')['0']['inner-group3'] as $k => $v){
						if($k=='0'){
							$detail_assistant_radiographers = $v['detail_assistant_radiographers'];
						}else{
							$detail_assistant_radiographers .= ",".$v['detail_assistant_radiographers'];
						}
					}
					$sRow->detail_assistant_radiographers		= $detail_assistant_radiographers;
					$sRowAll->detail_assistant_radiographers	= $detail_assistant_radiographers;	
				}

				$conclusion_fiber_size = null;
				if(is_null(request('outer-group5'))){
					$sRow->conclusion_fiber_size			= $conclusion_fiber_size;
					$sRowAll->conclusion_fiber_size			= $conclusion_fiber_size;
				}else{
					foreach(request('outer-group5')['0']['inner-group5'] as $k => $v){
						if($k=='0'){
							$conclusion_fiber_size = $v['conclusion_fiber_size'];
						}else{
							$conclusion_fiber_size .= ",".$v['conclusion_fiber_size'];
						}
					}				
					$sRow->conclusion_fiber_size			= $conclusion_fiber_size;
					$sRowAll->conclusion_fiber_size			= $conclusion_fiber_size;
				}

				$sRow->conclusion_frequency			= request('conclusion_frequency');		
				$sRow->conclusion_total_energy		= request('conclusion_total_energy');	
				$sRow->conclusion_total_shocks		= request('conclusion_total_shocks');	

				$sRow->conclusion_equipment_charge	= request('conclusion_equipment_charge');	
				
				$sRow->treatment_result_id			= request('treatment_result_id');	
				$sRow->treatment_comment			= request('treatment_comment');
				
				$sRow->litrotripsy_renal_enerry			= request('litrotripsy_renal_enerry'); 
				$sRow->litrotripsy_renal_frequency		= request('litrotripsy_renal_frequency');		 
				$sRow->litrotripsy_renal_power			= request('litrotripsy_renal_power');		 
				$sRow->litrotripsy_renal_fiber			= request('litrotripsy_renal_fiber');	

				$sRow->litrotripsy_ureteral_enerry		= request('litrotripsy_ureteral_enerry');	 
				$sRow->litrotripsy_ureteral_frequency	= request('litrotripsy_ureteral_frequency');	 
				$sRow->litrotripsy_ureteral_power		= request('litrotripsy_ureteral_power');	 
				$sRow->litrotripsy_ureteral_fiber		= request('litrotripsy_ureteral_fiber');	

				$sRow->litrotripsy_blader_enerry		= request('litrotripsy_blader_enerry');	 
				$sRow->litrotripsy_blader_frequency		= request('litrotripsy_blader_frequency'); 
				$sRow->litrotripsy_blader_power			= request('litrotripsy_blader_power'); 
				$sRow->litrotripsy_blader_fiber			= request('litrotripsy_blader_fiber');

				$sRow->litrotripsy_flexible_enerry		= request('litrotripsy_flexible_enerry');	 
				$sRow->litrotripsy_flexible_frequency	= request('litrotripsy_flexible_frequency');	 
				$sRow->litrotripsy_flexible_power		= request('litrotripsy_flexible_power');	 
				$sRow->litrotripsy_flexible_fiber		= request('litrotripsy_flexible_fiber');	 

				$sRow->tumore_ureteral_enerry			= request('tumore_ureteral_enerry');	 
				$sRow->tumore_ureteral_frequency		= request('tumore_ureteral_frequency');	 
				$sRow->tumore_ureteral_power			= request('tumore_ureteral_power');	 
				$sRow->tumore_ureteral_fiber			= request('tumore_ureteral_fiber');	

				$sRow->tumore_blader_enerry				= request('tumore_blader_enerry');
				$sRow->tumore_blader_frequency			= request('tumore_blader_frequency');	 
				$sRow->tumore_blader_power				= request('tumore_blader_power');	 
				$sRow->tumore_blader_fiber				= request('tumore_blader_fiber');	

				$sRow->tumore_incision_enerry			= request('tumore_incision_enerry');	 
				$sRow->tumore_incision_frequency		= request('tumore_incision_frequency');	 
				$sRow->tumore_incision_power			= request('tumore_incision_power');	 
				$sRow->tumore_incision_fiber			= request('tumore_incision_fiber');	
				
				// dd($sRow);
				$sRow->save();
				

				/* ---------------------------------------------------------------------------------------------------------- */

				/* All */									
				$sRowAll->detail_payment_other					= request('detail_payment_other');						
				$sRowAll->detail_anesthesia_other				= request('detail_anesthesia_other');
				
				$sRowAll->book_number3    						= request('book_number3_endo');
				$sRowAll->book_number5    						= request('book_number4_endo');
				$sRowAll->sheet_endou							= $sheet_endou;

				$sRowAll->detail_hos_id    						= request('detail_hos_id'); 
					
				$sRowAll->patient_id_number  					= request('patient_id_number');	
				$sRowAll->patient_name  						= request('patient_name');	
				$sRowAll->patient_hn_no  						= request('patient_hn_no');		
				$sRowAll->patient_phone_no  					= request('patient_phone_no');	
				$sRowAll->patient_age  							= request('patient_age');	
				$sRowAll->patient_sex_name 						= request('patient_sex_name');	

				$sRowAll->detail_date    						= date_format(date_create(request('detail_date')), "Y-m-d");
				$sRowAll->detail_timein  						= request('detail_timein');		
				$sRowAll->detail_timeout  						= request('detail_timeout');	

				$sRowAll->detail_anesthesiologist				= request('detail_anesthesiologist');	
				$sRowAll->detail_treating_physician  			= request('detail_treating_physician');		
				$sRowAll->detail_machine_types  				= request('detail_machine_types');

				$sRowAll->conclusion_frequency					= request('conclusion_frequency');		
				$sRowAll->conclusion_total_energy				= request('conclusion_total_energy');	
				$sRowAll->conclusion_total_shocks				= request('conclusion_total_shocks');

				$sRowAll->treatment_result_id					= request('treatment_result_id');	
				$sRowAll->treatment_comment						= request('treatment_comment');

				$sRowAll->litrotripsy_renal_enerry			= request('litrotripsy_renal_enerry'); 
				$sRowAll->litrotripsy_renal_frequency		= request('litrotripsy_renal_frequency');		 
				$sRowAll->litrotripsy_renal_power			= request('litrotripsy_renal_power');		 
				$sRowAll->litrotripsy_renal_fiber			= request('litrotripsy_renal_fiber');	

				$sRowAll->litrotripsy_ureteral_enerry		= request('litrotripsy_ureteral_enerry');	 
				$sRowAll->litrotripsy_ureteral_frequency	= request('litrotripsy_ureteral_frequency');	 
				$sRowAll->litrotripsy_ureteral_power		= request('litrotripsy_ureteral_power');	 
				$sRowAll->litrotripsy_ureteral_fiber		= request('litrotripsy_ureteral_fiber');	

				$sRowAll->litrotripsy_blader_enerry			= request('litrotripsy_blader_enerry');	 
				$sRowAll->litrotripsy_blader_frequency		= request('litrotripsy_blader_frequency'); 
				$sRowAll->litrotripsy_blader_power			= request('litrotripsy_blader_power'); 
				$sRowAll->litrotripsy_blader_fiber			= request('litrotripsy_blader_fiber');

				$sRowAll->litrotripsy_flexible_enerry		= request('litrotripsy_flexible_enerry');	 
				$sRowAll->litrotripsy_flexible_frequency	= request('litrotripsy_flexible_frequency');	 
				$sRowAll->litrotripsy_flexible_power		= request('litrotripsy_flexible_power');	 
				$sRowAll->litrotripsy_flexible_fiber		= request('litrotripsy_flexible_fiber');	 

				$sRowAll->tumore_ureteral_enerry			= request('tumore_ureteral_enerry');	 
				$sRowAll->tumore_ureteral_frequency			= request('tumore_ureteral_frequency');	 
				$sRowAll->tumore_ureteral_power				= request('tumore_ureteral_power');	 
				$sRowAll->tumore_ureteral_fiber				= request('tumore_ureteral_fiber');	

				$sRowAll->tumore_blader_enerry				= request('tumore_blader_enerry');
				$sRowAll->tumore_blader_frequency			= request('tumore_blader_frequency');	 
				$sRowAll->tumore_blader_power				= request('tumore_blader_power');	 
				$sRowAll->tumore_blader_fiber				= request('tumore_blader_fiber');	

				$sRowAll->tumore_incision_enerry			= request('tumore_incision_enerry');	 
				$sRowAll->tumore_incision_frequency			= request('tumore_incision_frequency');	 
				$sRowAll->tumore_incision_power				= request('tumore_incision_power');	 
				$sRowAll->tumore_incision_fiber				= request('tumore_incision_fiber');	

				// dd($sRowAll);
				$sRowAll->save();

				\DB::commit();
				
				return redirect()->action('Backend\Sheet\EndourologicPatientController@index')->with(['alert'=>\App\Models\Alert::Msg('success')]);
				} catch (\Exception $e) {
				echo $e->getMessage();
				\DB::rollback();
				return redirect()->action('Backend\Sheet\EndourologicPatientController@index')->with(['alert'=>\App\Models\Alert::e($e)]);
			}
		}
				
		public function edit($id)
		{
			try {
				$sRow 			= \App\Models\SheetEndourologicTransaction::find($id);
				// dd($sRow);					
				
				/* โรงพยาบาล */
				$sHospital 		= \App\Models\Backend\Masters\Hospital::orderBy('name', 'asc')->get();	
				/* แพทย์ */
				$sPhysician 	= \App\Models\Backend\Masters\Physician::orderBy('id', 'asc')->get();
				/* เครื่องที่ใช้รักษา */
				$sMachine 		= \App\Models\Backend\Masters\Machine::where('machinetypeid', '=', '4')->orderBy('id', 'asc')->get();
				/* ช่างเทคนิก*/
				$sTechnician 	= \App\Models\Backend\Masters\Technician::orderBy('id', 'asc')->get();
				/* ความช่วยเหลือ  */
				$sAssistance 	= \App\Models\Backend\Masters\Assistance::orderBy('id', 'asc')->get();
				/* เพศ */
				$sPatientSex 	= \App\Models\Backend\Masters\PatientSex::orderBy('id', 'asc')->get();
				/* ผู้ป่วย */
				$sPatient 		= \App\Models\Backend\Masters\Patient::orderBy('id', 'asc')->get();
				
				/* เพื่อเลือก หัวข้องาน */
				$sSheetEndourologic 		= \App\Models\Backend\Masters\SheetEndourologic::orderBy('sort', 'asc')->get();
				/* เพื่อเลือก payment */
				$sPayment 					= \App\Models\Backend\Masters\Payment::orderBy('sort', 'asc')->get();
				/* เพื่อเลือก fiber size */
				$sFiberSize 				= \App\Models\Backend\Masters\FiberSize::orderBy('id', 'asc')->get();
				/* เพื่อเลือก  anesthesia */
				$sAnesthesia 				= \App\Models\Backend\Masters\Anesthesia::orderBy('sort', 'asc')->get();
				/* เพื่อเลือก trettment result */
				$sTreatmentResult 			= \App\Models\Backend\Masters\TreatmentResult::orderBy('id', 'asc')->get();

				$sSheet_endou 						= explode(",",$sRow->sheet_endou);				
				$sDetail_radiographer 				= explode(",",$sRow->detail_radiographer);
				$sDetail_assistant_radiographers 	= explode(",",$sRow->detail_assistant_radiographers);
				
				$sDetail_payment 			= explode(",",$sRow->detail_payment);
				$sDetail_anesthesia 		= explode(",",$sRow->detail_anesthesia);
				$sConclusion_fiber_size 	= explode(",",$sRow->conclusion_fiber_size);
				
				// dd($sdetail_radiographer);
				return view('backend.sheet.endourologic-patient.form')->with(
					[
						'form_status'	=> 'edit',
						'sRow'			=> $sRow, 
						'sHospital'		=> $sHospital,						
						'sPatientSex'	=> $sPatientSex,
						'sPhysician'	=> $sPhysician,
						'sMachine'		=> $sMachine,
						'sTechnician'	=> $sTechnician,
						'sAssistance'	=> $sAssistance,
						'sPatient'		=> $sPatient,
						'sSheetEndourologic'		=> $sSheetEndourologic,
						'sPayment'					=> $sPayment,
						'sFiberSize'				=> $sFiberSize,
						'sAnesthesia'				=> $sAnesthesia,
						'sSheet_endou'				=> $sSheet_endou,
						'sTreatmentResult'			=> $sTreatmentResult,
						'sDetail_radiographer'				=> $sDetail_radiographer,
						'sDetail_assistant_radiographers'	=> $sDetail_assistant_radiographers,
						'sDetail_payment'			=> $sDetail_payment,
						'sDetail_anesthesia'		=> $sDetail_anesthesia,
						'sConclusion_fiber_size'	=> $sConclusion_fiber_size,
					]
				);
			} catch (\Exception $e) {
				return redirect()->action('Backend\Sheet\EndourologicPatientController@index')->with(['alert'=>\App\Models\Alert::e($e)]);
			}
		}
		
		
		public function destroy($id)
		{
			$sRow = \App\Models\SheetEndourologicTransaction::find($id);
			if( $sRow ){				
				// $sRow->forceDelete(); // ลบจริง
				$sRow->delete();
			}
			return response()->json(\App\Models\Alert::Msg('success'));
		}
		
		public function Datatable(){
			$sTable = \App\Models\SheetEndourologicTransaction::search()->orderBy('id', 'desc');
			$sQuery = \DataTables::of($sTable);
			return $sQuery
			// ->addColumn('book_auto_all', function($row) { return $row->book_auto_y.$row->book_auto_m.$row->book_auto; })
			->addColumn('hospital_name', function($row) {
				return is_null($row->hospital->name) ? '-' : $row->hospital->name;
			})
			->addColumn('physician_name', function($row) {
				return is_null($row->physician->names) ? '-' : $row->physician->names;
			})
			->addColumn('detail_date', function($row) {
				return is_null($row->detail_date) ? '-' : date_format(date_create($row->detail_date), 'd-m-Y');
			})
			->addColumn('updated_at', function($row) {
				return is_null($row->updated_at) ? '-' : $row->updated_at;
			})
			->make(true);
		}		
		
	}
