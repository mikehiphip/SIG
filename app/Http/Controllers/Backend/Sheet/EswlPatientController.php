<?php
	
	namespace App\Http\Controllers\Backend\Sheet;
	
	use Illuminate\Http\Request;
	use App\Http\Controllers\Controller;
	use Yajra\DataTables\DataTables;
	use DB;
	
	class EswlPatientController extends Controller 
	{
		
		public function index(Request $request)
		{
			// return "Test";			
			return view('backend.sheet.eswl-patient.index');
		}
		
		public function create()
		{		
			// return "Test";
			$sHospital 		= \App\Models\Backend\Masters\Hospital::orderBy('id', 'asc')->get();
			$sSheetEswl 	= \App\Models\Backend\Masters\SheetEswl::orderBy('id', 'asc')->get();
			$sPatientSex 	= \App\Models\Backend\Masters\PatientSex::orderBy('id', 'asc')->get();
			$sPhysician 	= \App\Models\Backend\Masters\Physician::orderBy('id', 'asc')->get();
			$sMachine 		= \App\Models\Backend\Masters\Machine::where('machinetypeid', '=', '2')->orderBy('id', 'asc')->get();
			$sTechnician 	= \App\Models\Backend\Masters\Technician::orderBy('id', 'asc')->get();
			$sAssistance 	= \App\Models\Backend\Masters\Assistance::orderBy('id', 'asc')->get();
			$sPatient 		= \App\Models\Backend\Masters\Patient::orderBy('id', 'asc')
							->where('book_number3', '!=', '')
							->where('book_number5', '!=', '')
							->get();
			// echo "<pre>";
			// print_r($sPatient);
			// echo "<pre>";
			// exit();
			$sMedical_radiographer 				= array();
			$sMedical_assistant_radiographers 	= array();
			// dd($sPatientSex);
			return view('backend.sheet.eswl-patient.form')->with(
				[
					'form_status'	=> 'add', 
					'sHospital'		=> $sHospital, 
					'sSheetEswl'	=> $sSheetEswl, 
					'sPatientSex'	=> $sPatientSex,
					'sPhysician'	=> $sPhysician,
					'sMachine'		=> $sMachine,
					'sTechnician'	=> $sTechnician,
					'sAssistance'	=> $sAssistance,
					'sPatient'		=> $sPatient,
					'sMedical_radiographer'				=> $sMedical_radiographer,
					'sMedical_assistant_radiographers'	=> $sMedical_assistant_radiographers,
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
		
		/* จำนวนการรักษาผู้ป่วย */
		public function callTxnoGetCount(Request $request){
			// dd($request->all());
			$v_ref_patient_id 		= $request['p_ref_patient_id'];			
			$sqleswl   	= "select count(*) round_count from nm_sheet_eswl_transaction where patient_id='$v_ref_patient_id'";
			
            $roweswl 	= DB::select($sqleswl);
			$roweswl	= $roweswl['0'];
			$row_round_count	= $roweswl->round_count;			
			
			
			$datas 		= array(
				"r_status"	=> 'y',
				"r_txno"	=> $row_round_count
			);
			return json_encode($datas);			
		}
		/* ราคาผรักษาผู้ป่วย */
		public function callExpenses(Request $request){
			// dd($request->all());
			// dd($request['p_hos_id']);
			$v_hos_id 			= $request['p_hos_id'];
			$v_hos_price_id 	= $request['p_hos_price_id'];
			$v_treatment_txno 	= ($request['p_treatment_txno'])?($request['p_treatment_txno']-1):0;
			$sqlhos   	= "select price from nm_hospital_price where id_hosp='$v_hos_id' and id_eswl='$v_hos_price_id'";
			// echo $sqlhos; exit();
            $rowhos 	= DB::select($sqlhos);
			$rowhos		= $rowhos['0'];
			$rowprice	= $rowhos->price;			
			if($rowprice != ''){
				$sPrice 	= explode(",",$rowprice);
				$sPriceCount	= count($sPrice);
				// dd($sPriceCount);
				
				if($sPriceCount==1){
					$sPriceFinal = $rowprice;
				}else{
					$sPriceFinal = $sPrice[$v_treatment_txno];
				}
			}else{
				$sPriceFinal = 0;
			}
			
			$datas 		= array(
				"r_status"	=> 'y',
				"r_price"	=> $sPriceFinal
			);
			return json_encode($datas);			
		}
		
		/* ประวัติผู้ป่วย */
		public function callPatient(Request $request){
			// dd($request->all());
			// dd($request['p_patient_name']);
			 
			$v_form_status 		= $request['p_form_status'];			
			$v_patient_id_old 	= $request['p_patient_id_old'];	
			
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
						book_number3,
						book_number5,
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
				$r_patient_book_number3	= $rowpatient->book_number3;						
				$r_patient_book_number5	= $rowpatient->book_number5;						
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
			
			/* ประวัติผู้ป่วยใน transaction */
				$v_hos_id = $r_patient_id_hosp;
				$sqltx   	= "
					select count(*) as tx_no_c
					from nm_sheet_eswl_transaction
					where treatment_hos_id='$v_hos_id' and patient_id='$v_patient_id'
				";
				// echo $sqlpatient; exit();
				$rowtx 	= DB::select($sqltx);
				$rowtx	= $rowtx['0'];
				$r_tx_no	= $rowtx->tx_no_c+1;
			/* // ประวัติผู้ป่วย transaction */
			
			// dd($rowtx->tx_no_c);
			if($rowtx->tx_no_c > 0){
				$sql_treatment_hos_price   	= "
					select treatment_hos_price_id from nm_sheet_eswl_transaction 
					where treatment_hos_id='$v_hos_id' and patient_id='$v_patient_id' 
					order by id desc limit 1
				";
				// echo $sql_treatment_hos_price; exit();
				$row_treatment_hos_price 	= DB::select($sql_treatment_hos_price);
				$v_treatment_hos_price_id	= $row_treatment_hos_price['0']->treatment_hos_price_id;
			}else{
				$v_treatment_hos_price_id	= "";
			}		
			
			$datas 		= array(
				"r_status"	=> 'y',
				"r_patient_name"			=> $r_patient_name,
				"r_patient_id_number"		=> $r_patient_id_number,
				"r_patient_hn_no"			=> $r_patient_hn_no,
				"r_patient_phone_no"		=> $r_patient_phone_no,				
				"r_patient_sex_name"		=> $r_patient_sex_name,
				"r_patient_age"				=> $r_patient_age,
				"r_tx_no"					=> $r_tx_no,
				"r_patient_book_number3"	=> $r_patient_book_number3,
				"r_patient_book_number5"	=> $r_patient_book_number5,
				"r_patient_id_hosp"			=> $r_patient_id_hosp,
				"r_treatment_hos_price_id"	=> $v_treatment_hos_price_id
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
					$sRow = \App\Models\SheetEswlTransaction::find($id);
					$v_reference_code = $sRow->reference_code;		
					// dd($v_reference_code);

					/* All */
					$sRowAll 	= new \App\Models\SheetAllTransaction;		
					$sRowAll 	= $sRowAll->where('sheettype', 'eswl');	
					$sRowAll 	= $sRowAll->where('reference_code', "$v_reference_code");	
					$sRowAll 	= $sRowAll->first();				
					// dd($sRowAll);
				}else{
					$v_book_auto_y = date("Y");
					$v_book_auto_m = date("m");
					$sqlmax 	= "select (MAX(CONVERT(book_auto, SIGNED))+1) as idmax from nm_sheet_eswl_transaction where book_auto_y='$v_book_auto_y' and book_auto_m='$v_book_auto_m'";					
					$rowmax_arr = DB::select($sqlmax);		
					$rowmax		= ($rowmax_arr['0']->idmax!='') ? str_pad($rowmax_arr['0']->idmax, 5, '0', STR_PAD_LEFT) : '00001';
					
					/* Main */
					$sRow = new \App\Models\SheetEswlTransaction;				
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
					$sRowAll->sheettype					= 'eswl';
				}	
				
				/* Main */
				$sRow->book_number3    				= request('book_number3');
				$sRow->book_number5    				= request('book_number5');				
				$sRow->treatment_hos_id    			= request('treatment_hos_id');
				$sRow->treatment_date    			= date_format(date_create(request('treatment_date')), "Y-m-d");
				$sRow->treatment_lithotripter 		= request('treatment_lithotripter');
				$sRow->treatment_txno  				= request('treatment_txno');
				$sRow->treatment_hos_price_id  		= request('treatment_hos_price_id');	
				$sRow->treatment_hos_price_manual  	= request('treatment_hos_price_manual');	
				$sRow->treatment_shock_count_start  = request('treatment_shock_count_start');	
				$sRow->treatment_shock_count_finish = request('treatment_shock_count_finish');	
				$sRow->treatment_timein  			= request('treatment_timein');		
				$sRow->treatment_timeout  			= request('treatment_timeout');		
					
				$sRow->patient_name  				= request('patient_name');		
				$sRow->patient_id_number  			= request('patient_id_number');		
				$sRow->patient_hn_no  				= request('patient_hn_no');		
				$sRow->patient_phone_no  			= request('patient_phone_no');		
				$sRow->patient_sex_id  				= request('patient_sex_id');		
				$sRow->patient_sex_name 			= request('patient_sex_name');		
				$sRow->patient_age  				= request('patient_age');		
				$sRow->medical_treating_physician  	= request('medical_treating_physician');		
				$sRow->medical_machine_types  		= request('medical_machine_types');	
				
				$medical_radiographer = null;
				if(is_null(request('outer-group1'))){
					$sRow->medical_radiographer			= $medical_radiographer;
					$sRowAll->detail_radiographer		= $medical_radiographer;				/* All */
				}else{
					/* DashBoard Radiographer Delete */					
					$sRowDashBoardRadiographerDel = \App\Models\SheetEswlTransactionRadiographer::where('nm_sheet_eswl_transaction_id', $id)->forceDelete();
					
					foreach(request('outer-group1')['0']['inner-group1'] as $k => $v){
						if($k=='0'){
							$medical_radiographer = $v['medical_radiographer'];
						}else{
							$medical_radiographer .= ",".$v['medical_radiographer'];
						}

						/* DashBoard Radiographer Add */
						if($v['medical_radiographer'] != ''){	
							$sRowDashBoardRadiographerAdd = new \App\Models\SheetEswlTransactionRadiographer;
							$sRowDashBoardRadiographerAdd->nm_sheet_eswl_transaction_id	= $id;
							$sRowDashBoardRadiographerAdd->nm_technician_id				= $v['medical_radiographer'];
							$sRowDashBoardRadiographerAdd->save();
						}
					}				
					$sRow->medical_radiographer			= $medical_radiographer;
					$sRowAll->detail_radiographer		= $medical_radiographer;				/* All */
				}

				$medical_assistant_radiographers = null;
				if(is_null(request('outer-group2'))){
					$sRow->medical_assistant_radiographers		= $medical_assistant_radiographers;
					$sRowAll->detail_assistant_radiographers	= $medical_assistant_radiographers;				/* All */
				}else{
					foreach(request('outer-group2')['0']['inner-group2'] as $k => $v){
						if($k=='0'){
							$medical_assistant_radiographers = $v['medical_assistant_radiographers'];
						}else{
							$medical_assistant_radiographers .= ",".$v['medical_assistant_radiographers'];
						}
					}
					$sRow->medical_assistant_radiographers		= $medical_assistant_radiographers;	
					$sRowAll->detail_assistant_radiographers	= $medical_assistant_radiographers;				/* All */
				}
				
				$sRow->stone_size_1					= request('stone_size_1');		
				$sRow->stone_size_2					= request('stone_size_2');		
				$sRow->medical_expenses				= request('medical_expenses');		
				$sRow->medical_expenses_manual		= request('medical_expenses_manual');		
				
				// dd($sRow);
				// $sRow->active    	= request('active')?request('active'):'N';				
				// if( request('locale_id') ){
					// $sRow->locale_id    = request('locale_id');
				// }else{
					// $sRow->locale_id    = \Auth::user()->locale_id;
				// }				
				$sRow->save();
				
				if (request('image')) {
					@unlink('public/asset/images/eswlpatient/'.$sRow->thumb);
					@unlink('public/asset/images/eswlpatient/'.$sRow->image);
					$path = 'public/asset/images/eswlpatient/';
					$sName = str_pad($sRow->id, 5, '0', STR_PAD_LEFT);
					$ext = '.' . strtolower(request('image')->getClientOriginalExtension());
					//$image = \Image::make(request('files')->getRealPath());
					$image = \Image::make(request('image')->getPathName());
					$image->resize(1600, null, function ($constraint) {
						$constraint->aspectRatio();
					});
					$image->save($path . $sName . $ext);

					$image->resize(1600, null, function ($constraint) {
						$constraint->aspectRatio();
					});
					$image->save($path . $sName . '_thumb' . $ext);
					$image->destroy();
					
					$sRow->img = $sName;
					$sRow->ext = $ext;
					$sRow->save();
				}else{
					$sName 		= '';
					$ext 		= '';
				}
				
				/* ---------------------------------------------------------------------------------------------------------- */

				/* All */
				$sRowAll->book_number3    				= request('book_number3');							// M
				$sRowAll->book_number5    				= request('book_number5');
				$sRowAll->treatment_txno  				= request('treatment_txno');
				$sRowAll->img 							= $sName;
				$sRowAll->ext 							= $ext;

				$sRowAll->detail_hos_id					= request('treatment_hos_id');

				$sRowAll->patient_name  				= request('patient_name');		
				$sRowAll->patient_id_number  			= request('patient_id_number');		
				$sRowAll->patient_hn_no  				= request('patient_hn_no');		
				$sRowAll->patient_phone_no  			= request('patient_phone_no');	
				$sRowAll->patient_sex_name 				= request('patient_sex_name');		
				$sRowAll->patient_age  					= request('patient_age');								

				$sRowAll->detail_date					= date_format(date_create(request('treatment_date')), "Y-m-d");
				$sRowAll->detail_timein					= request('treatment_timein');	
				$sRowAll->detail_timeout				= request('treatment_timeout');	
				$sRowAll->medical_expenses				= request('medical_expenses');
				$sRowAll->medical_expenses_manual		= request('medical_expenses_manual');

				$sRowAll->detail_treating_physician		= request('medical_treating_physician');
				$sRowAll->detail_machine_types			= request('medical_machine_types');

				$sRowAll->stone_size_1					= request('stone_size_1');
				$sRowAll->stone_size_2					= request('stone_size_2');
				$sRowAll->treatment_shock_count_start	= request('treatment_shock_count_start');
				$sRowAll->treatment_shock_count_finish	= request('treatment_shock_count_finish');

				$sRowAll->treatment_hos_price_id		= request('treatment_hos_price_id');
				$sRowAll->treatment_hos_price_manual	= request('treatment_hos_price_manual');

				$sRowAll->save();

				\DB::commit();
				
				return redirect()->action('Backend\Sheet\EswlPatientController@index')->with(['alert'=>\App\Models\Alert::Msg('success')]);
			} catch (\Exception $e) {
				echo $e->getMessage();
				\DB::rollback();
				return redirect()->action('Backend\Sheet\EswlPatientController@index')->with(['alert'=>\App\Models\Alert::e($e)]);
			}
		}
				
		public function edit($id)
		{
			try {
				$sRow 			= \App\Models\SheetEswlTransaction::find($id);
				// dd($sRow->medical_radiographer);
				// dd($sRow->medical_assistant_radiographers);
				
				$sHospital 		= \App\Models\Backend\Masters\Hospital::orderBy('name', 'asc')->get();
				$sSheetEswl 	= \App\Models\Backend\Masters\SheetEswl::orderBy('id', 'asc')->get();
				$sPatientSex 	= \App\Models\Backend\Masters\PatientSex::orderBy('id', 'asc')->get();
				$sPhysician 	= \App\Models\Backend\Masters\Physician::orderBy('id', 'asc')->get();
				$sMachine 		= \App\Models\Backend\Masters\Machine::where('machinetypeid', '=', '2')->orderBy('id', 'asc')->get();
				$sTechnician 	= \App\Models\Backend\Masters\Technician::orderBy('id', 'asc')->get();
				$sAssistance 	= \App\Models\Backend\Masters\Assistance::orderBy('id', 'asc')->get();
				$sPatient 		= \App\Models\Backend\Masters\Patient::orderBy('id', 'asc')->get();				
				$sMedical_radiographer = explode(",",$sRow->medical_radiographer);
				$sMedical_assistant_radiographers = explode(",",$sRow->medical_assistant_radiographers);
				// return View('backend.sheet.eswl-patient.form')->with(array('sRow'=>$sRow) );
				// dd($sMedical_radiographer);
				return view('backend.sheet.eswl-patient.form')->with(
					[
						'form_status'	=> 'edit',
						'sRow'			=> $sRow, 
						'sHospital'		=> $sHospital, 
						'sSheetEswl'	=> $sSheetEswl, 
						'sPatientSex'	=> $sPatientSex,
						'sPhysician'	=> $sPhysician,
						'sMachine'		=> $sMachine,
						'sTechnician'	=> $sTechnician,
						'sAssistance'	=> $sAssistance,
						'sPatient'		=> $sPatient,
						'sMedical_radiographer'				=> $sMedical_radiographer,
						'sMedical_assistant_radiographers'	=> $sMedical_assistant_radiographers,
					]
				);
			} catch (\Exception $e) {
				return redirect()->action('Backend\Sheet\EswlPatientController@index')->with(['alert'=>\App\Models\Alert::e($e)]);
			}
		}
		
		
		public function destroy($id)
		{
			$sRow = \App\Models\SheetEswlTransaction::find($id);
			if( $sRow ){
				@unlink('public/asset/images/eswlpatient/'.$sRow->thumb);
				@unlink('public/asset/images/eswlpatient/'.$sRow->image);
				// $sRow->forceDelete(); // ลบจริง
				$sRow->delete();
			}
			return response()->json(\App\Models\Alert::Msg('success'));
		}
		
		public function Datatable(){
			$sTable = \App\Models\SheetEswlTransaction::search()->orderBy('id', 'desc');
			$sQuery = \DataTables::of($sTable);
			return $sQuery
			// ->addColumn('book_auto_all', function($row) { return $row->book_auto_y.$row->book_auto_m.$row->book_auto; })
			->addColumn('hospital_name', function($row) {
				return is_null($row->hospital->name) ? '-' : $row->hospital->name;
			})
			->addColumn('physician_name', function($row) {
				return is_null($row->physician->names) ? '-' : $row->physician->names;
			})
			->addColumn('treatment_date', function($row) {
				return is_null($row->treatment_date) ? '-' : date_format(date_create($row->treatment_date), 'd-m-Y');
			})
			->addColumn('updated_at', function($row) {
				return is_null($row->updated_at) ? '-' : $row->updated_at;
			})
			->make(true);
		}		
		
	}
