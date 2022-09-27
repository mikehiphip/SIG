<?php
	
	namespace App\Http\Controllers\Backend\Sheet;
	
	use Illuminate\Http\Request;
	use App\Http\Controllers\Controller;
	use Yajra\DataTables\DataTables;
	use DB;
	
	class SurgicalPatientController extends Controller 
	{
		
		public function index(Request $request)
		{
			// return "Test";			
			return view('backend.sheet.surgical-patient.index');
		}
		
		public function create()
		{		
			// return "Test";
			/* โรงพยาบาล */
			$sHospital 		= \App\Models\Backend\Masters\Hospital::orderBy('name', 'asc')->get();
			/* surgical */
			// $sSheetEswl 	= \App\Models\Backend\Masters\SheetEswl::orderBy('id', 'asc')->get();			
			/* แพทย์ */
			$sPhysician 	= \App\Models\Backend\Masters\Physician::orderBy('id', 'asc')->get();
			/* เครื่องที่ใช้รักษา */
			$sMachine 		= \App\Models\Backend\Masters\Machine::where('machinetypeid', '=', '5')->orderBy('id', 'asc')->get();
			/* ช่างเทคนิก*/
			$sTechnician 	= \App\Models\Backend\Masters\Technician::orderBy('id', 'asc')->get();
			/* ความช่วยเหลือ  */
			$sAssistance 	= \App\Models\Backend\Masters\Assistance::orderBy('id', 'asc')->get();
			/* เพศ */
			$sPatientSex 	= \App\Models\Backend\Masters\PatientSex::orderBy('id', 'asc')->get();
			/* ผู้ป่วย */
			$sPatient 		= \App\Models\Backend\Masters\Patient::orderBy('name_first', 'asc')
							->where('book_number3_surg', '!=', '')
							->where('book_number4_surg', '!=', '')
							->get();
							
			
			/* เพื่อเลือก หัวข้องาน */
			$sSheetSurgical 			= \App\Models\Backend\Masters\SheetSurgical::orderBy('sort', 'asc')->get();
			// dd($sSheetSurgical);
			
			/* เพื่อเลือก payment */
			$sPayment 					= \App\Models\Backend\Masters\Payment::orderBy('sort', 'asc')->get();
			
			/* เพื่อเลือก  anesthesia */
			$sAnesthesia 				= \App\Models\Backend\Masters\Anesthesia::orderBy('sort', 'asc')->get();
			$sDetail_anesthesia 		= array();
			
			/* เพื่อเลือก  TransurethralProcedures */
			$sTransurethralProcedures	= \App\Models\Backend\Masters\TransurethralProcedures::orderBy('sort', 'asc')->get();
			
			/* เพื่อเลือก fiber size */
			$sOpticalFiberSize 			= \App\Models\Backend\Masters\OpticalFiberSize::orderBy('sort', 'asc')->get();
			
			/* เพื่อเลือก  BipolarResectoscope */
			$sBipolarResectoscope 		= \App\Models\Backend\Masters\BipolarResectoscope::orderBy('sort', 'asc')->get();			
			
			/* เพื่อเลือก trettment result */
			$sTreatmentResult 			= \App\Models\Backend\Masters\TreatmentResult::orderBy('id', 'asc')->get();
			
			$sDetail_radiographer 				= array();
			$sDetail_assistant_radiographers 	= array();	
			
			$sSheet_surgical 					= array();				
			$sDetail_payment 					= array();
			$sDetail_TransurethralProcedures	= array();		
			$sConclusion_fiber_size 			= array();
			$sDetail_BipolarResectoscope 		= array();			
			
			// dd($sPatientSex);
			return view('backend.sheet.surgical-patient.form')->with(
				[
					'form_status'				=> 'add', 
					'sHospital'					=> $sHospital,					
					'sPatientSex'				=> $sPatientSex,
					'sPhysician'				=> $sPhysician,
					'sMachine'					=> $sMachine,
					'sTechnician'				=> $sTechnician,
					'sAssistance'				=> $sAssistance,
					'sAnesthesia'				=> $sAnesthesia,
					'sDetail_anesthesia'		=> $sDetail_anesthesia,					
					'sTransurethralProcedures'	=> $sTransurethralProcedures,				
					'sPatient'					=> $sPatient,					
					'sSheetSurgical'			=> $sSheetSurgical,
					'sPayment'					=> $sPayment,
					'sTreatmentResult'			=> $sTreatmentResult,
					'sOpticalFiberSize'			=> $sOpticalFiberSize,
					'sBipolarResectoscope'		=> $sBipolarResectoscope,					
					'sDetail_radiographer'				=> $sDetail_radiographer,
					'sDetail_assistant_radiographers'	=> $sDetail_assistant_radiographers,					
					'sSheet_surgical'					=> $sSheet_surgical,
					'sDetail_payment'					=> $sDetail_payment,
					'sDetail_TransurethralProcedures'	=> $sDetail_TransurethralProcedures,
					'sConclusion_fiber_size'			=> $sConclusion_fiber_size,
					'sDetail_BipolarResectoscope'		=> $sDetail_BipolarResectoscope,
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
						book_number3_surg, 
						book_number4_surg,
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
				$r_patient_book_number3	= $rowpatient->book_number3_surg;						
				$r_patient_book_number4	= $rowpatient->book_number4_surg;					
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
					$sRow 		= \App\Models\SheetSurgicalTransaction::find($id);					
					$v_reference_code = $sRow->reference_code;		
					// dd($v_reference_code);

					/* All */
					$sRowAll 	= new \App\Models\SheetAllTransaction;		
					$sRowAll 	= $sRowAll->where('sheettype', 'surg');	
					$sRowAll 	= $sRowAll->where('reference_code', "$v_reference_code");	
					$sRowAll 	= $sRowAll->first();				
					// dd($sRowAll);		
				}else{

					$v_book_auto_y = date("Y");
					$v_book_auto_m = date("m");
					$sqlmax 	= "select (MAX(CONVERT(book_auto, SIGNED))+1) as idmax from nm_sheet_surgical_transaction where book_auto_y='$v_book_auto_y' and book_auto_m='$v_book_auto_m'";					
					$rowmax_arr = DB::select($sqlmax);		
					$rowmax		= ($rowmax_arr['0']->idmax!='') ? str_pad($rowmax_arr['0']->idmax, 5, '0', STR_PAD_LEFT) : '00001';
					
					/* Main */
					$sRow = new \App\Models\SheetSurgicalTransaction;				
					$sRow->book_auto    				= $rowmax;
					$sRow->book_auto_y    				= $v_book_auto_y;
					$sRow->book_auto_m    				= $v_book_auto_m;
					$sRow->reference_code    			= $v_book_auto_y.$v_book_auto_m.$rowmax;
				
					$sRow->patient_id  					= request('patient_id');

					/* All */
					$sRowAll 	= new \App\Models\SheetAllTransaction;
					$sRowAll->book_auto    				= $rowmax;
					$sRowAll->book_auto_y    			= $v_book_auto_y;
					$sRowAll->book_auto_m    			= $v_book_auto_m;
					$sRowAll->reference_code    		= $v_book_auto_y.$v_book_auto_m.$rowmax;
				
					$sRowAll->patient_id  				= request('patient_id');
					$sRowAll->sheettype					= 'surg';	

				}		

				/* Main */		
				$sRow->book_number3    					= request('book_number3_surg');
				$sRow->book_number4    					= request('book_number4_surg');
				$sheet_surgical = "";
				foreach(request('sheet_surgical') as $k => $v){
					if($k=='0'){
						$sheet_surgical = $v;
					}else{
						$sheet_surgical .= ",".$v;
					}
				}				
				$sRow->sheet_surgical			= $sheet_surgical;								
				$sRow->detail_hos_id    		= request('detail_hos_id'); 			// Hidden				
				// $sRow->patient_id  				= request('patient_id');		
				$sRow->patient_id_number  		= request('patient_id_number');	
				$sRow->patient_name  			= request('patient_name');	
				$sRow->patient_hn_no  			= request('patient_hn_no');								
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
					$sRowAll->detail_anesthesia			= $detail_anesthesia;			/* All */
				}else{
					foreach(request('outer-group4')['0']['inner-group4'] as $k => $v){
						if($k=='0'){
							$detail_anesthesia = $v['detail_anesthesia'];
						}else{
							$detail_anesthesia .= ",".$v['detail_anesthesia'];
						}
					}				
					$sRow->detail_anesthesia			= $detail_anesthesia;
					$sRowAll->detail_anesthesia			= $detail_anesthesia;			/* All */
				}
				$sRow->detail_anesthesia_other		= request('detail_anesthesia_other');			
				
				$sRow->detail_anesthesiologist		= request('detail_anesthesiologist');	
				$sRow->detail_treating_physician  	= request('detail_treating_physician');		
				$sRow->detail_machine_types  		= request('detail_machine_types');	
				
				$detail_radiographer = null;
				if(is_null(request('outer-group2'))){
					$sRow->detail_radiographer			= $detail_radiographer;	
					$sRowAll->detail_radiographer		= $detail_radiographer;			/* All */
				}else{
					/* DashBoard Radiographer Delete */					
					$sRowDashBoardRadiographerDel = \App\Models\SheetSurgicalTransactionRadiographer::where('nm_sheet_surgical_transaction_id', $id)->forceDelete();

					foreach(request('outer-group2')['0']['inner-group2'] as $k => $v){
						if($k=='0'){
							$detail_radiographer = $v['detail_radiographer'];
						}else{
							$detail_radiographer .= ",".$v['detail_radiographer'];
						}

						/* DashBoard Radiographer Add */
						if($v['detail_radiographer'] != ''){	
							$sRowDashBoardRadiographerAdd = new \App\Models\SheetSurgicalTransactionRadiographer;
							$sRowDashBoardRadiographerAdd->nm_sheet_surgical_transaction_id	= $id;
							$sRowDashBoardRadiographerAdd->nm_technician_id					= $v['detail_radiographer'];
							$sRowDashBoardRadiographerAdd->save();
						}
					}				
					$sRow->detail_radiographer			= $detail_radiographer;	
					$sRowAll->detail_radiographer		= $detail_radiographer;			/* All */
				}

				$detail_assistant_radiographers = null;
				if(is_null(request('outer-group3'))){
					$sRow->detail_assistant_radiographers		= $detail_assistant_radiographers;
					$sRowAll->detail_assistant_radiographers	= $detail_assistant_radiographers;			/* All */
				}else{
					foreach(request('outer-group3')['0']['inner-group3'] as $k => $v){
						if($k=='0'){
							$detail_assistant_radiographers = $v['detail_assistant_radiographers'];
						}else{
							$detail_assistant_radiographers .= ",".$v['detail_assistant_radiographers'];
						}
					}
					$sRow->detail_assistant_radiographers		= $detail_assistant_radiographers;	
					$sRowAll->detail_assistant_radiographers	= $detail_assistant_radiographers;			/* All */
				}

				$optical_fiber_size = null;
				if(is_null(request('outer-group3'))){
					$sRow->optical_fiber_size		= $optical_fiber_size;
					$sRowAll->optical_fiber_size	= $optical_fiber_size;				/* All */
				}else{
					foreach(request('outer-group6')['0']['inner-group6'] as $k => $v){
						if($k=='0'){
							$optical_fiber_size = $v['optical_fiber_size'];
						}else{
							$optical_fiber_size .= ",".$v['optical_fiber_size'];
						}
					}				
					$sRow->optical_fiber_size	= $optical_fiber_size;
					$sRowAll->optical_fiber_size	= $optical_fiber_size;				/* All */
				}
				
				$sRow->treatment_conclusion_incision_cutting	= request('treatment_conclusion_incision_cutting');		
				$sRow->treatment_conclusion_coagulation			= request('treatment_conclusion_coagulation');	
				$sRow->treatment_conclusion_vaporization		= request('treatment_conclusion_vaporization');	
				$sRow->treatment_conclusion_total_energy		= request('treatment_conclusion_total_energy');	
				$sRow->treatment_conclusion_total_time			= request('treatment_conclusion_total_time');	
				
				$sRow->remart									= request('remart');	
				
				$sRow->treatment_result_id						= request('treatment_result_id');	
				$sRow->treatment_comment						= request('treatment_comment');
				
				$sRow->prostate_bladder_tumor_size				= request('prostate_bladder_tumor_size');

				$transurethral_procedures = null;
				if(is_null(request('outer-group5'))){
					$sRow->transurethral_procedures				= $transurethral_procedures;
					$sRowAll->transurethral_procedures			= $transurethral_procedures;				/* All */
				}else{	
					foreach(request('outer-group5')['0']['inner-group5'] as $k => $v){
						if($k=='0'){
							$transurethral_procedures = $v['transurethral_procedures'];
						}else{
							$transurethral_procedures .= ",".$v['transurethral_procedures'];
						}
					}				
					$sRow->transurethral_procedures				= $transurethral_procedures;
					$sRowAll->transurethral_procedures			= $transurethral_procedures;				/* All */
				}
				$sRow->transurethral_procedures_other			= request('transurethral_procedures_other');	
				
				$sRow->endoscopic_sheath						= request('endoscopic_sheath');	
				$sRow->holmium_laser_no							= request('holmium_laser_no');	 
								
				$sRow->electrode_no								= request('electrode_no');
				
				$electrode_select = null;
				if(is_null(request('outer-group7'))){
					$sRow->electrode_select			= $electrode_select;
					$sRowAll->electrode_select		= $electrode_select;				/* All */
				}else{
					foreach(request('outer-group7')['0']['inner-group7'] as $k => $v){
						if($k=='0'){
							$electrode_select = $v['electrode_select'];
						}else{
							$electrode_select .= ",".$v['electrode_select'];
						}
					}				
					$sRow->electrode_select			= $electrode_select;
					$sRowAll->electrode_select		= $electrode_select;				/* All */	
				}					
				
				$sRow->treatment_result_name	= request('treatment_result_name');								
				$sRow->treatment_free			= request('treatment_free');				
				
				$sRow->save();
				
		/* ---------------------------------------------------------------------------------------------------------- */

				/* All */									
				$sRowAll->detail_payment_other					= request('detail_payment_other');						
				$sRowAll->detail_anesthesia_other				= request('detail_anesthesia_other');	
				$sRowAll->transurethral_procedures_other		= request('transurethral_procedures_other');				

				$sRowAll->book_number3    						= request('book_number3_surg');							// M
				$sRowAll->book_number5    						= request('book_number4_surg');							// M	
				$sRowAll->sheet_surgical						= $sheet_surgical;											
				$sRowAll->detail_hos_id    						= request('detail_hos_id'); 													
				$sRowAll->patient_id_number  					= request('patient_id_number');							// M
				$sRowAll->patient_name  						= request('patient_name');								// M
				$sRowAll->patient_hn_no  						= request('patient_hn_no');								// M		
				$sRowAll->patient_age  							= request('patient_age');	
				$sRowAll->patient_sex_name 						= request('patient_sex_name');	
				// $sRowAll->patient_birthdate						= date_format(date_create(request('patient_birthdate')), "Y-m-d");							
				
				$sRowAll->detail_date    						= date_format(date_create(request('detail_date')), "Y-m-d");
				$sRowAll->detail_timein  						= request('detail_timein');		
				$sRowAll->detail_timeout  						= request('detail_timeout');								
				
				$sRowAll->detail_anesthesiologist				= request('detail_anesthesiologist');	
				$sRowAll->detail_treating_physician  			= request('detail_treating_physician');		
				$sRowAll->detail_machine_types  				= request('detail_machine_types');						
				
				$sRowAll->treatment_conclusion_incision_cutting	= request('treatment_conclusion_incision_cutting');		
				$sRowAll->treatment_conclusion_coagulation		= request('treatment_conclusion_coagulation');	
				$sRowAll->treatment_conclusion_vaporization		= request('treatment_conclusion_vaporization');	
				$sRowAll->treatment_conclusion_total_energy		= request('treatment_conclusion_total_energy');	
				$sRowAll->treatment_conclusion_total_time		= request('treatment_conclusion_total_time');	
				
				$sRowAll->remart								= request('remart');	
				
				$sRowAll->treatment_result_id					= request('treatment_result_id');	
				$sRowAll->treatment_comment						= request('treatment_comment');
				
				$sRowAll->prostate_bladder_tumor_size			= request('prostate_bladder_tumor_size');
				
				$sRowAll->endoscopic_sheath						= request('endoscopic_sheath');	
				$sRowAll->holmium_laser_no						= request('holmium_laser_no');	 
								
				$sRowAll->electrode_no							= request('electrode_no');				
				
				$sRowAll->treatment_result_name					= request('treatment_result_name');			

				$sRowAll->treatment_free						= request('treatment_free');
			
				$sRowAll->save();

				\DB::commit();
				
				return redirect()->action('Backend\Sheet\SurgicalPatientController@index')->with(['alert'=>\App\Models\Alert::Msg('success')]);
				} catch (\Exception $e) {
				echo $e->getMessage();
				\DB::rollback();
				return redirect()->action('Backend\Sheet\SurgicalPatientController@index')->with(['alert'=>\App\Models\Alert::e($e)]);
			}
		}
				
		public function edit($id)
		{
			try {
				$sRow 			= \App\Models\SheetSurgicalTransaction::find($id);
				// dd($sRow);					
				
				/* โรงพยาบาล */
				$sHospital 		= \App\Models\Backend\Masters\Hospital::orderBy('name', 'asc')->get();	
				/* แพทย์ */
				$sPhysician 	= \App\Models\Backend\Masters\Physician::orderBy('id', 'asc')->get();
				/* เครื่องที่ใช้รักษา */
				$sMachine 		= \App\Models\Backend\Masters\Machine::where('machinetypeid', '=', '5')->orderBy('id', 'asc')->get();
				/* ช่างเทคนิก*/
				$sTechnician 	= \App\Models\Backend\Masters\Technician::orderBy('id', 'asc')->get();
				/* ความช่วยเหลือ  */
				$sAssistance 	= \App\Models\Backend\Masters\Assistance::orderBy('id', 'asc')->get();
				/* เพศ */
				$sPatientSex 	= \App\Models\Backend\Masters\PatientSex::orderBy('id', 'asc')->get();
				/* ผู้ป่วย */
				$sPatient 		= \App\Models\Backend\Masters\Patient::orderBy('id', 'asc')->get();
				
				/* เพื่อเลือก หัวข้องาน */
				$sSheetSurgical 		= \App\Models\Backend\Masters\SheetEndourologic::orderBy('sort', 'asc')->get();
				/* เพื่อเลือก payment */
				$sPayment 					= \App\Models\Backend\Masters\Payment::orderBy('sort', 'asc')->get();
				
				/* เพื่อเลือก  anesthesia */
				$sAnesthesia 				= \App\Models\Backend\Masters\Anesthesia::orderBy('sort', 'asc')->get();
				$sDetail_anesthesia 		= array();
			
				/* เพื่อเลือก  TransurethralProcedures */
				$sTransurethralProcedures	= \App\Models\Backend\Masters\TransurethralProcedures::orderBy('sort', 'asc')->get();
				
				/* เพื่อเลือก fiber size */
				$sOpticalFiberSize 			= \App\Models\Backend\Masters\OpticalFiberSize::orderBy('id', 'asc')->get();
				
				/* เพื่อเลือก  BipolarResectoscope */
				$sBipolarResectoscope 		= \App\Models\Backend\Masters\BipolarResectoscope::orderBy('sort', 'asc')->get();
				
				/* เพื่อเลือก trettment result */
				$sTreatmentResult 			= \App\Models\Backend\Masters\TreatmentResult::orderBy('id', 'asc')->get();

				// dd($sRow); SSheet_endou
				$sDetail_radiographer 				= explode(",",$sRow->detail_radiographer);
				$sDetail_assistant_radiographers 	= explode(",",$sRow->detail_assistant_radiographers);
				
				$sDetail_payment 					= explode(",",$sRow->detail_payment);
				$sDetail_BipolarResectoscope 		= explode(",",$sRow->electrode_select);
				$sConclusion_fiber_size 			= explode(",",$sRow->optical_fiber_size);
				
				$sSheet_surgical 					= explode(",",$sRow->sheet_surgical);
				$sDetail_TransurethralProcedures 	= explode(",",$sRow->transurethral_procedures);
				
				// dd($sdetail_radiographer);
				return view('backend.sheet.surgical-patient.form')->with(
					[
						'form_status'	=> 'edit',
						'sRow'			=> $sRow, 
						'sHospital'		=> $sHospital,						
						'sPatientSex'	=> $sPatientSex,
						'sPhysician'	=> $sPhysician,
						'sMachine'		=> $sMachine,
						'sTechnician'	=> $sTechnician,
						'sAssistance'	=> $sAssistance,
						'sAnesthesia'	=> $sAnesthesia,
						'sDetail_anesthesia'		=> $sDetail_anesthesia,					
						'sTransurethralProcedures'	=> $sTransurethralProcedures,
						'sPatient'					=> $sPatient,
						'sSheetSurgical'			=> $sSheetSurgical,
						'sPayment'					=> $sPayment,
						'sOpticalFiberSize'					=> $sOpticalFiberSize,
						'sBipolarResectoscope'				=> $sBipolarResectoscope,
						// 'sSheet_endou'						=> $sSheet_endou,
						'sTreatmentResult'					=> $sTreatmentResult,
						'sOpticalFiberSize'					=> $sOpticalFiberSize,
						'sBipolarResectoscope'				=> $sBipolarResectoscope,		
						'sDetail_radiographer'				=> $sDetail_radiographer,
						'sDetail_assistant_radiographers'	=> $sDetail_assistant_radiographers,
						'sSheet_surgical'					=> $sSheet_surgical,
						'sDetail_payment'					=> $sDetail_payment,
						'sDetail_BipolarResectoscope'		=> $sDetail_BipolarResectoscope,
						'sConclusion_fiber_size'			=> $sConclusion_fiber_size,
						'sDetail_TransurethralProcedures'	=> $sDetail_TransurethralProcedures,
					]
				);
			} catch (\Exception $e) {
				return redirect()->action('Backend\Sheet\SurgicalPatientController@index')->with(['alert'=>\App\Models\Alert::e($e)]);
			}
		}
		
		
		public function destroy($id)
		{
			$sRow = \App\Models\SheetSurgicalTransaction::find($id);
			if( $sRow ){				
				// $sRow->forceDelete(); // ลบจริง
				$sRow->delete();
			}
			return response()->json(\App\Models\Alert::Msg('success'));
		}
		
		public function Datatable(){
			$sTable = \App\Models\SheetSurgicalTransaction::search()->orderBy('id', 'desc');
			
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
